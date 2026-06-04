<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::latest()
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->paginate($request->per_page ?? 48);

        if ($request->expectsJson()) {
            return response()->json($media);
        }

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
        ]);

        $file     = $request->file('file');
        $mimeType = $file->getMimeType();
        $type     = str_starts_with($mimeType, 'image/') ? 'image' : 'file';
        $disk     = $type === 'image' ? 'public' : 'private';

        if ($type === 'image') {
            $filename = Str::uuid() . '.jpg';
            $path     = 'media/' . $filename;
            $savePath = storage_path('app/public/' . $path);

            if (!file_exists(storage_path('app/public/media'))) {
                mkdir(storage_path('app/public/media'), 0755, true);
            }

            \Intervention\Image\ImageManager::gd()
                ->read($file)
                ->scaleDown(width: 1920)
                ->toJpeg(quality: 80)
                ->save($savePath);

            $size = filesize($savePath);
        } else {
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('media', $filename, $disk);
            $size     = $file->getSize();
        }

        $media = Media::create([
            'name'      => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $mimeType,
            'type'      => $type,
            'size'      => $size,
            'disk'      => $disk,
        ]);

        return response()->json([
            'success' => true,
            'media'   => $media, // url & size_label sudah di-append otomatis dari model
        ]);
    }

    public function download(Media $media)
    {
        if ($media->disk === 'private') {
            if (!Storage::disk('private')->exists($media->file_path)) {
                abort(404, 'File tidak ditemukan.');
            }
            return Storage::disk('private')->download($media->file_path, $media->file_name);
        }

        // Disk public
        $fullPath = storage_path('app/public/' . $media->file_path);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($fullPath, $media->file_name);
    }

    public function destroy(Media $media)
    {
        Storage::disk($media->disk)->delete($media->file_path);
        $media->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'File berhasil dihapus!');
    }

    public function find(Request $request)
    {
        $media = Media::where('file_path', $request->file_path)->first();

        if (!$media) {
            return response()->json(null, 404);
        }

        return response()->json($media);
    }
}
