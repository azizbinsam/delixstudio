<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductManagerController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('type', 'product')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:file,license',
            'status' => 'required|in:draft,published',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'title.required'       => 'Judul wajib diisi.',
            'title.max'            => 'Judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'type.required'        => 'Tipe produk wajib dipilih.',
            'type.in'              => 'Tipe produk tidak valid.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status tidak valid.',
        ]);

        $thumbnail = null;
        if ($request->filled('thumbnail')) {
            $thumbnail = $request->thumbnail;
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'demo_url' => $request->demo_url,
            'tutorial_url' => $request->tutorial_url,
            'thumbnail' => $thumbnail,
            'price' => $request->price,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        // Simpan file dari media library
        if ($request->filled('product_file')) {
            $media = \App\Models\Media::where('file_path', $request->product_file)->first();
            if ($media) {
                ProductFile::create([
                    'product_id' => $product->id,
                    'file_name' => $media->file_name,
                    'file_path' => $media->file_path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('type', 'product')->get();
        $product->load('files');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:file,license',
            'status' => 'required|in:draft,published',
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'title.required'       => 'Judul wajib diisi.',
            'title.max'            => 'Judul maksimal 255 karakter.',
            'description.required' => 'Deskripsi wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'type.required'        => 'Tipe produk wajib dipilih.',
            'type.in'              => 'Tipe produk tidak valid.',
            'status.required'      => 'Status wajib dipilih.',
            'status.in'            => 'Status tidak valid.',
        ]);

        $thumbnail = $product->thumbnail;
        if ($request->filled('thumbnail')) {
            $thumbnail = $request->thumbnail;
        }

        $product->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'demo_url' => $request->demo_url,
            'tutorial_url' => $request->tutorial_url,
            'thumbnail' => $thumbnail,
            'price' => $request->price,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        // Update file jika ada yang baru dipilih
        if ($request->filled('product_file')) {
            $media = \App\Models\Media::where('file_path', $request->product_file)->first();
            if ($media) {
                // Hapus file lama
                $product->files()->delete();

                ProductFile::create([
                    'product_id' => $product->id,
                    'file_name' => $media->file_name,
                    'file_path' => $media->file_path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
