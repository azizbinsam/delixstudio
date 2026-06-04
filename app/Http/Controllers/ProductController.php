<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        SEOMeta::setTitle('Semua Produk - Delix Studio');
        SEOMeta::setDescription('Temukan template, UI kit, dan produk digital berkualitas di Delix Studio.');
        SEOMeta::setCanonical(url('/products'));

        OpenGraph::setTitle('Semua Produk - Delix Studio');
        OpenGraph::setDescription('Temukan template, UI kit, dan produk digital berkualitas di Delix Studio.');
        OpenGraph::setUrl(url('/products'));

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

        SEOMeta::setTitle($product->title . ' - Delix Studio');
        SEOMeta::setDescription($product->description);
        SEOMeta::setCanonical(url("/products/{$slug}"));
        SEOMeta::addKeyword([
            $product->title,
            'template ' . $product->type,
            $product->category->name ?? 'produk digital',
            'delix studio'
        ]);

        OpenGraph::setTitle($product->title);
        OpenGraph::setDescription($product->description);
        OpenGraph::setUrl(url("/products/{$slug}"));
        OpenGraph::setType('product');
        OpenGraph::addImage(asset('storage/' . $product->thumbnail));

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
