<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLicense extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'wp_admin_url',
        'username',
        'password',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
