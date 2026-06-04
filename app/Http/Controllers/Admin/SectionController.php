<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
        ]);

        Section::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'order' => $request->order,
        ]);

        return back()->with('success', 'Section berhasil ditambahkan!');
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $section->update([
            'title' => $request->title,
            'order' => $request->order,
        ]);

        return back()->with('success', 'Section berhasil diperbarui!');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return back()->with('success', 'Section berhasil dihapus!');
    }
}
