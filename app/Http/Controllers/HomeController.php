<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Product;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class HomeController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Delix Studio - Platform E-Learning & E-Commerce WordPress');
        SEOMeta::setDescription('Belajar dari kelas premium dan dapatkan tema & plugin WordPress terbaik. Semua dalam satu platform untuk developer Indonesia.');
        SEOMeta::setCanonical(url('/'));

        OpenGraph::setTitle('Delix Studio');
        OpenGraph::setDescription('Belajar dari kelas premium dan dapatkan tema & plugin WordPress terbaik. Semua dalam satu platform untuk developer Indonesia.');
        OpenGraph::setUrl(url('/'));
        OpenGraph::addImage(asset('images/og-image.jpg'));

        $featuredCourses = Course::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        $featuredProducts = Product::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        return view('pages.home', compact('featuredCourses', 'featuredProducts'));
    }
}
