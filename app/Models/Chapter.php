<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'description',
        'youtube_url',
        'order',
        'is_free',
    ];

    protected function casts(): array
    {
        return [
            'is_free' => 'boolean',
        ];
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
