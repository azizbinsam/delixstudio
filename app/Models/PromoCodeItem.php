<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodeItem extends Model
{
    protected $fillable = [
        'promo_code_id',
        'promotable_type',
        'promotable_id',
    ];

    // ─── Relasi ─────────────────────────────────────────────────────────────

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    /**
     * Polymorphic: bisa Course atau Product
     */
    public function promotable()
    {
        return $this->morphTo();
    }
}
