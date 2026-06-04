<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChapterProgress extends Model
{
    use HasFactory;

    protected $table = 'chapter_progress';

    protected $fillable = [
        'user_id',
        'chapter_id',
        'course_id',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
