<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        // dd($products);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status','active')->get();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'category_id' => 'required',
            'price' => 'required',
            'thumbnail' => 'nullable|image',
            'images.*' => 'nullable|image',
            'status' => 'required'
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'category_id' => $request->category_id,
            'price' => str_replace(['Rp','.', ' '], '', $request->price),
            'stock' => $request->stock ?? 0,
            'thumbnail' => $thumbnailPath,
            'is_featured' => $request->has('is_featured'),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('super-admin.products.index')
            ->with('success', 'Product berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        $product->load('category','images');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status','active')->get();
        $product->load('images');
        return view('admin.products.form', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'category_id' => 'required',
            'price' => 'required',
            'thumbnail' => 'nullable|image',
            'images.*' => 'nullable|image',
            'status' => 'required'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $product->thumbnail = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'category_id' => $request->category_id,
            'price' => str_replace(['Rp','.', ' '], '', $request->price),
            'stock' => $request->stock ?? 0,
            'is_featured' => $request->has('is_featured'),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('super-admin.products.index')
            ->with('success', 'Product berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->status = 'deleted';
        $product->save();

        // if ($product->thumbnail) {
        //     Storage::disk('public')->delete($product->thumbnail);
        // }

        // foreach ($product->images as $img) {
        //     Storage::disk('public')->delete($img->image);
        // }

        // $product->delete();

        return redirect()->route('super-admin.products.index')
            ->with('success', 'Product berhasil dihapus');
    }
}
