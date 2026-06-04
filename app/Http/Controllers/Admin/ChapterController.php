<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function store(Request $request, Section $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|string',
            'order' => 'required|integer|min:1',
            'is_free' => 'boolean',
        ]);

        Chapter::create([
            'section_id' => $section->id,
            'title' => $request->title,
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'order' => $request->order,
            'is_free' => $request->boolean('is_free'),
        ]);

        return back()->with('success', 'Chapter berhasil ditambahkan!');
    }

    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => 'required|string',
            'order' => 'required|integer|min:1',
            'is_free' => 'boolean',
        ]);

        $chapter->update([
            'title' => $request->title,
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'order' => $request->order,
            'is_free' => $request->boolean('is_free'),
        ]);

        return back()->with('success', 'Chapter berhasil diperbarui!');
    }

    public function destroy(Chapter $chapter)
    {
        $chapter->delete();
        return back()->with('success', 'Chapter berhasil dihapus!');
    }
}
