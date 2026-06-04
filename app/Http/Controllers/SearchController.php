<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('status', 'published')
            ->where('title', 'like', '%' . $query . '%')
            ->with('category')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'id'        => $item->id,
                'title'     => $item->title,
                'subtitle'  => $item->category?->name . ' · ' . ($item->price == 0 ? 'Gratis' : 'Rp ' . number_format($item->price, 0, ',', '.')),
                'thumbnail' => $item->thumbnail ? Storage::url($item->thumbnail) : null,
                'icon'      => 'fa-box',
                'url'       => route('products.show', $item->slug),
            ]);

        $courses = Course::where('status', 'published')
            ->where('title', 'like', '%' . $query . '%')
            ->with('category')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'id'        => $item->id,
                'title'     => $item->title,
                'subtitle'  => $item->category?->name . ' · ' . ucfirst($item->level),
                'thumbnail' => $item->thumbnail ? Storage::url($item->thumbnail) : null,
                'icon'      => 'fa-play-circle',
                'url'       => route('courses.show', $item->slug),
            ]);

        return response()->json([
            'Produk' => $products,
            'Kelas'  => $courses,
        ]);
    }
}
