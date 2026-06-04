<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'overview_video',
        'whatsapp_group',
        'price',
        'level',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tools()
    {
        return $this->hasMany(CourseTool::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }
}
