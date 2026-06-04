<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_name',
        'file_path',
        'mime_type',
        'type',
        'size',
        'disk',
    ];

    protected $appends = ['url', 'size_formatted', 'size_label'];

    public function getUrlAttribute(): string
    {
        if ($this->disk === 'public') {
            return Storage::disk('public')->url($this->file_path);
        }

        return route('admin.media.download', $this->id);
    }

    public function getSizeFormattedAttribute(): string
    {
        $bytes = $this->size ?? 0;

        if ($bytes < 1024)       return $bytes . ' B';
        if ($bytes < 1048576)    return round($bytes / 1024, 1) . ' KB';
        if ($bytes < 1073741824) return round($bytes / 1048576, 1) . ' MB';

        return round($bytes / 1073741824, 1) . ' GB';
    }

    // Alias untuk kompatibilitas dengan component Blade
    public function getSizeLabelAttribute(): string
    {
        return $this->size_formatted;
    }
}
