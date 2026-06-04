<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('status', 'published')
            ->with('category')
            ->when(request('category'), fn($q) => $q->whereHas('category', fn($q) => $q->where('slug', request('category'))))
            ->when(request('price') === 'free', fn($q) => $q->where('price', 0))
            ->when(request('price') === 'paid', fn($q) => $q->where('price', '>', 0))
            ->latest()
            ->paginate(12)
            ->withQueryString(); // ← penting agar ?category=xxx ikut di pagination

        $categories = Category::where('type', 'product')->get();

        return view('pages.products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'files'])
            ->firstOrFail();

        $hasPurchased = false;

        if (Auth::check()) {
            $hasPurchased = Auth::user()->orders()
                ->where('status', 'paid')
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('itemable_type', Product::class)
                        ->where('itemable_id', $product->id);
                })->exists();
        }

        return view('pages.products.show', compact('product', 'hasPurchased'));
    }
}
