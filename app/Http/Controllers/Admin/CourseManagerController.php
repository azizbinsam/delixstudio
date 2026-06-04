<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseTool;
use App\Models\Section;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseManagerController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::where('type', 'course')->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'thumbnail' => 'nullable|string',
                'overview_video' => 'nullable|string',
                'whatsapp_group' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'level' => 'required|in:beginner,intermediate,advanced',
                'status' => 'required|in:draft,published',
                'tools' => 'nullable|array',
                'tools.*.name' => 'nullable|string|max:255',
                'tools.*.icon' => 'nullable|string|max:255',
            ],
            [
                'category_id.required' => 'Kategori wajib dipilih.',
                'category_id.exists'   => 'Kategori tidak valid.',
                'title.required'       => 'Judul kelas wajib diisi.',
                'title.max'            => 'Judul kelas maksimal 255 karakter.',
                'description.required' => 'Deskripsi wajib diisi.',
                'price.required'       => 'Harga wajib diisi.',
                'price.numeric'        => 'Harga harus berupa angka.',
                'price.min'            => 'Harga tidak boleh negatif.',
                'level.required'       => 'Level wajib dipilih.',
                'level.in'             => 'Level tidak valid.',
                'status.required'      => 'Status wajib dipilih.',
                'status.in'            => 'Status tidak valid.',
                'tools.*.name.required' => 'Nama tool ke-:position wajib diisi.',
                'tools.*.name.max'      => 'Nama tool ke-:position maksimal 255 karakter.',
            ]
        );

        $thumbnail = null;
        if ($request->filled('thumbnail')) {
            // Dari media library (path string)
            $thumbnail = ltrim(str_replace(asset('storage') . '/', '', $request->thumbnail), '/');
            // Pastikan bersih dari /storage/ prefix
            $thumbnail = str_replace('storage/', '', $thumbnail);
        } elseif ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('courses', 'public');
        }

        $course = Course::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'overview_video' => $request->overview_video,
            'whatsapp_group' => $request->whatsapp_group,
            'price' => $request->price,
            'level' => $request->level,
            'status' => $request->status,
        ]);

        // Simpan tools
        if ($request->tools) {
            foreach ($request->tools as $tool) {
                if (empty($tool['name'])) continue;
                CourseTool::create([
                    'course_id' => $course->id,
                    'name' => $tool['name'],
                    'icon' => $tool['icon'] ?? null,
                    'url' => $tool['url'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function show(Course $course)
    {
        $course->load(['sections.chapters', 'tools']);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::where('type', 'course')->get();
        $course->load(['tools', 'sections.chapters']);
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|string',
            'overview_video' => 'nullable|string',
            'whatsapp_group' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'status' => 'required|in:draft,published',
            'tools' => 'nullable|array',
            'tools.*.name' => 'nullable|string|max:255',
            'tools.*.icon' => 'nullable|string|max:255',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'title.required'       => 'Judul kelas wajib diisi.',
            'title.max'            => 'Judul kelas maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'level.required'       => 'Level wajib dipilih.',
            'level.in'             => 'Level tidak valid.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status tidak valid.',
            'tools.*.name.required' => 'Nama tool ke-:position wajib diisi.',
            'tools.*.name.max'      => 'Nama tool ke-:position maksimal 255 karakter.',
        ]);

        $thumbnail = $course->thumbnail;
        if ($request->filled('thumbnail')) {
            $thumbnail = ltrim(str_replace(asset('storage') . '/', '', $request->thumbnail), '/');
            $thumbnail = str_replace('storage/', '', $thumbnail);
        } elseif ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $thumbnail = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'overview_video' => $request->overview_video,
            'whatsapp_group' => $request->whatsapp_group,
            'price' => $request->price,
            'level' => $request->level,
            'status' => $request->status,
        ]);

        // Update tools
        $course->tools()->delete();
        if ($request->tools) {
            foreach ($request->tools as $tool) {
                if (empty($tool['name'])) continue;
                CourseTool::create([
                    'course_id' => $course->id,
                    'name' => $tool['name'],
                    'icon' => $tool['icon'] ?? null,
                    'url' => $tool['url'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(Course $course)
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
