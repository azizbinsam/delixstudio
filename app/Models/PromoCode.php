<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_purchase',
        'max_usage',
        'used_count',
        'expired_at',
        'is_active',
        'show_in_banner',
        'scope',
    ];

    protected $appends = ['item_ids'];

    protected function casts(): array
    {
        return [
            'expired_at' => 'date:d-m-Y',
            'is_active' => 'boolean',
            'value' => 'integer',
            'minimum_purchase' => 'integer',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function items()
    {
        return $this->hasMany(PromoCodeItem::class);
    }

    public function isApplicableTo(Model $item): bool
    {
        return match ($this->scope) {
            'all'          => true,
            'all_courses'  => $item instanceof Course,
            'all_products' => $item instanceof Product,
            'specific'     => $this->items()
                ->where('promotable_type', get_class($item))
                ->where('promotable_id', $item->id)
                ->exists(),
            default        => false,
        };
    }

    public function isApplicableToCart(array $cart): bool
    {
        foreach ($cart as $item) {
            $model = $item['type'] === 'course'
                ? Course::find($item['id'])
                : Product::find($item['id']);

            if ($model && $this->isApplicableTo($model)) {
                return true;
            }
        }

        return false;
    }

    public function calculateDiscount(int|float $price): int
    {
        $discount = $this->type === 'percentage'
            ? ($price * $this->value / 100)
            : $this->value;

        // Diskon tidak boleh melebihi harga
        return (int) min($price, $discount);
    }

    public function calculateCartDiscount(array $cart): int
    {
        if (in_array($this->scope, ['all', 'all_courses', 'all_products'])) {
            // Berlaku untuk subtotal keseluruhan yang sesuai scope
            $applicableSubtotal = collect($cart)
                ->filter(function ($item) {
                    $model = $item['type'] === 'course'
                        ? Course::find($item['id'])
                        : Product::find($item['id']);
                    return $model && $this->isApplicableTo($model);
                })
                ->sum('price');

            return $this->calculateDiscount($applicableSubtotal);
        }

        // scope = 'specific': hitung per item yang cocok
        $total = 0;
        foreach ($cart as $item) {
            $model = $item['type'] === 'course'
                ? Course::find($item['id'])
                : Product::find($item['id']);

            if ($model && $this->isApplicableTo($model)) {
                $total += $this->calculateDiscount($item['price']);
            }
        }

        return $total;
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->expired_at && $this->expired_at->isPast()) return false;
        if ($this->max_usage && $this->used_count >= $this->max_usage) return false;

        return true;
    }

    public function getScopeLabelAttribute(): string
    {
        return match ($this->scope) {
            'all'          => 'Semua Produk & Kelas',
            'all_courses'  => 'Semua Kelas',
            'all_products' => 'Semua Produk',
            'specific'     => 'Item Tertentu',
            default        => '-',
        };
    }

    public function getItemIdsAttribute()
    {
        return $this->items->map(function ($item) {
            return ($item->promotable_type === Course::class
                ? 'course'
                : 'product') . '_' . $item->promotable_id;
        })->values();
    }
}
