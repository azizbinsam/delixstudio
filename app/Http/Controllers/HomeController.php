<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
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
