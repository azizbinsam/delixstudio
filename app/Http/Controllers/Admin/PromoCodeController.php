<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\PromoCodeItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::latest()->paginate(10);
        $courses    = Course::where('status', 'published')->orderBy('title')->get();
        $products   = Product::where('status', 'published')->orderBy('title')->get();

        $selectorItems = collect()
            ->merge(
                $courses->map(fn($course) => [
                    'id' => 'course_' . $course->id,
                    'title' => $course->title,
                    'type' => 'course',
                ])
            )
            ->merge(
                $products->map(fn($product) => [
                    'id' => 'product_' . $product->id,
                    'title' => $product->title,
                    'type' => 'product',
                ])
            )
            ->values();
        return view('admin.promo-codes.index', compact('promoCodes', 'courses', 'products', 'selectorItems'));
    }

    public function create()
    {
        $courses  = Course::where('status', 'published')->orderBy('title')->get();
        $products = Product::where('status', 'published')->orderBy('title')->get();

        $selectorItems = collect()
            ->merge(
                $courses->map(fn($course) => [
                    'id' => 'course_' . $course->id,
                    'title' => $course->title,
                    'type' => 'course',
                ])
            )
            ->merge(
                $products->map(fn($product) => [
                    'id' => 'product_' . $product->id,
                    'title' => $product->title,
                    'type' => 'product',
                ])
            )
            ->values();

        return view('admin.promo-codes.create', compact('courses', 'products', 'selectorItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'             => 'required|string|max:50',
            'type'             => 'required|in:percentage,fixed',
            'value'            => 'required|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'max_usage'        => 'nullable|integer|min:1',
            'expired_at'       => 'nullable|date|after:today',
            'is_active'        => 'boolean',
            'scope'            => 'required|in:all,all_courses,all_products,specific',
            'item_ids'         => 'required_if:scope,specific|array',
            'item_ids.*'       => 'string', // format: "course_1" atau "product_5"
        ]);

        $code     = strtoupper($request->code);
        $existing = PromoCode::withTrashed()->where('code', $code)->first();

        $data = [
            'type'             => $request->type,
            'value'            => $request->value,
            'minimum_purchase' => $request->minimum_purchase ?? 0,
            'max_usage'        => $request->max_usage,
            'used_count'       => 0,
            'expired_at'       => $request->filled('expired_at')
                ? \Carbon\Carbon::parse($request->expired_at)->format('Y-m-d')
                : null,
            'is_active'        => $request->boolean('is_active', true),
            'show_in_banner' => $request->boolean('show_in_banner'),
            'scope'            => $request->scope,
        ];

        if ($existing) {
            $existing->restore();
            $existing->update($data);
            $promo = $existing;
        } else {
            $promo = PromoCode::create(array_merge(['code' => $code], $data));
        }

        if ($request->boolean('show_in_banner')) {
            PromoCode::where('id', '!=', $promo->id)
                ->update(['show_in_banner' => false]);
        }

        // Sync item spesifik jika scope = specific
        $this->syncSpecificItems($promo, $request);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Kode promo berhasil ditambahkan!');
    }

    public function edit(PromoCode $promoCode)
    {
        $courses  = Course::where('status', 'published')->orderBy('title')->get();
        $products = Product::where('status', 'published')->orderBy('title')->get();

        $selectorItems = collect()
            ->merge(
                $courses->map(fn($course) => [
                    'id' => 'course_' . $course->id,
                    'title' => $course->title,
                    'type' => 'course',
                ])
            )
            ->merge(
                $products->map(fn($product) => [
                    'id' => 'product_' . $product->id,
                    'title' => $product->title,
                    'type' => 'product',
                ])
            )
            ->values();

        // Ambil item yang sudah terpilih untuk ditampilkan di form
        $selectedItems = $promoCode->items
            ->map(function ($item) {
                return (
                    $item->promotable_type === Course::class
                    ? 'course'
                    : 'product'
                ) . '_' . $item->promotable_id;
            })
            ->values()
            ->toArray();

        return view('admin.promo-codes.edit', compact('promoCode', 'courses', 'products', 'selectorItems', 'selectedItems'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('promo_codes', 'code')
                    ->ignore($promoCode->id)
                    ->whereNull('deleted_at'),
            ],
            'type'             => 'required|in:percentage,fixed',
            'value'            => 'required|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'max_usage'        => 'nullable|integer|min:1',
            'expired_at'       => 'nullable|date',
            'is_active'        => 'boolean',
            'scope'            => 'required|in:all,all_courses,all_products,specific',
            'item_ids'         => 'required_if:scope,specific|array',
            'item_ids.*'       => 'string',
        ]);

        $promoCode->update([
            'code'             => strtoupper($request->code),
            'type'             => $request->type,
            'value'            => $request->value,
            'minimum_purchase' => $request->minimum_purchase ?? 0,
            'max_usage'        => $request->max_usage,
            'expired_at'       => $request->filled('expired_at')
                ? \Carbon\Carbon::parse($request->expired_at)->format('Y-m-d')
                : null,
            'is_active'        => $request->boolean('is_active', true),
            'show_in_banner' => $request->boolean('show_in_banner'),
            'scope'            => $request->scope,
        ]);

        if ($request->boolean('show_in_banner')) {
            PromoCode::where('id', '!=', $promoCode->id)
                ->update(['show_in_banner' => false]);
        }

        $this->syncSpecificItems($promoCode, $request);

        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Kode promo berhasil diperbarui!');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return redirect()->route('admin.promo-codes.index')
            ->with('success', 'Kode promo berhasil dihapus!');
    }

    // ─── Helper ─────────────────────────────────────────────────────────────

    /**
     * Sync item spesifik ke tabel promo_code_items.
     * Item dikirim sebagai array ["course_1", "product_3", "course_5", ...]
     */
    private function syncSpecificItems(PromoCode $promo, Request $request): void
    {
        // Hapus dulu semua item lama
        $promo->items()->delete();

        if ($request->scope !== 'specific' || empty($request->item_ids)) {
            return;
        }

        foreach ($request->item_ids as $raw) {
            [$type, $id] = explode('_', $raw, 2);

            $modelClass = $type === 'course' ? Course::class : Product::class;
            $model      = $modelClass::find($id);

            if (!$model) continue;

            PromoCodeItem::create([
                'promo_code_id'  => $promo->id,
                'promotable_type' => get_class($model),
                'promotable_id'   => $model->id,
            ]);
        }
    }
}
