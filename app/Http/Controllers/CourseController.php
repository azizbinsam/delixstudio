<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        SEOMeta::setTitle('Semua Course - Delix Studio');
        SEOMeta::setDescription('Jelajahi semua course premium di Delix Studio. Belajar programming, design, dan lainnya.');
        SEOMeta::setCanonical(url('/courses'));

        OpenGraph::setTitle('Semua Course - Delix Studio');
        OpenGraph::setDescription('Jelajahi semua course premium di Delix Studio.');
        OpenGraph::setUrl(url('/courses'));

        $courses = Course::where('status', 'published')
            ->with('category')
            ->when(request('category'), fn($q) => $q->whereHas('category', fn($q) => $q->where('slug', request('category'))))
            ->when(request('price') === 'free', fn($q) => $q->where('price', 0))
            ->when(request('price') === 'paid', fn($q) => $q->where('price', '>', 0))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('type', 'course')->get();

        return view('pages.courses.index', compact('courses', 'categories'));
    }

    public function learn($slug, $chapterId)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->with(['sections.chapters', 'tools'])
            ->firstOrFail();

        $hasPurchased = Auth::user()->orders()
            ->where('status', 'paid')
            ->whereHas('items', function ($query) use ($course) {
                $query->where('itemable_type', Course::class)
                    ->where('itemable_id', $course->id);
            })->exists();

        $chapter = \App\Models\Chapter::findOrFail($chapterId);

        if (!$hasPurchased && !$chapter->is_free) {
            return redirect()->route('courses.show', $slug)
                ->with('error', 'Kamu harus membeli kelas ini untuk mengakses chapter ini.');
        }

        // Ambil progress user untuk kelas ini
        $completedChapterIds = \App\Models\ChapterProgress::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->pluck('chapter_id')
            ->toArray();

        $allChapters = $course->sections->flatMap(fn($s) => $s->chapters);
        $currentIndex = $allChapters->search(fn($c) => $c->id === $chapter->id);
        $prevChapter = $currentIndex > 0 ? $allChapters[$currentIndex - 1] : null;
        $nextChapter = $currentIndex < $allChapters->count() - 1 ? $allChapters[$currentIndex + 1] : null;

        return view('pages.courses.learn', compact(
            'course',
            'chapter',
            'hasPurchased',
            'prevChapter',
            'nextChapter',
            'completedChapterIds'
        ));
    }

    public function markProgress($slug, $chapterId)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $chapter = \App\Models\Chapter::findOrFail($chapterId);

        \App\Models\ChapterProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'chapter_id' => $chapterId,
            ],
            [
                'course_id' => $course->id,
                'completed_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'tools', 'sections.chapters'])
            ->firstOrFail();

        SEOMeta::setTitle($course->title . ' - Delix Studio');
        SEOMeta::setDescription($course->description);
        SEOMeta::setCanonical(url("/courses/{$slug}"));
        SEOMeta::addKeyword([
            $course->title,
            'course ' . $course->level,
            $course->category->name ?? 'course',
            'delix studio'
        ]);

        OpenGraph::setTitle($course->title);
        OpenGraph::setDescription($course->description);
        OpenGraph::setUrl(url("/courses/{$slug}"));
        OpenGraph::setType('article');
        OpenGraph::addImage(asset('storage/' . $course->thumbnail));

        $hasPurchased = false;

        if (Auth::check()) {
            $hasPurchased = Auth::user()->orders()
                ->where('status', 'paid')
                ->whereHas('items', function ($query) use ($course) {
                    $query->where('itemable_type', Course::class)
                        ->where('itemable_id', $course->id);
                })->exists();
        }

        return view('pages.courses.show', compact('course', 'hasPurchased'));
    }
}
