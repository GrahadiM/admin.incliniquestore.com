<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return view('admin.categories.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:categories,slug',
            'status' => 'required|in:active,inactive',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('super-admin.categories.index')
            ->with('success', 'Category berhasil ditambahkan');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:categories,slug' . $category->id,
            'status' => 'required|in:active,inactive',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('super-admin.categories.index')
            ->with('success', 'Category berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->status = 'deleted';
        $category->save();
        // $category->delete();

        return redirect()->route('super-admin.categories.index')->with('success', 'Category berhasil dihapus');
    }
}
