<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTool extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'icon',
        'url',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
