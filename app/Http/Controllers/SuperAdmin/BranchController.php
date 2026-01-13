<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BranchStore;

class BranchController extends Controller
{
    public function index()
    {
        $branches = BranchStore::all();
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        $branch = null;
        return view('admin.branches.form', compact('branch'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branch_stores,code',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        BranchStore::create($request->all());

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch berhasil dibuat.');
    }

    public function show(BranchStore $branch)
    {
        return view('admin.branches.show', compact('branch'));
    }

    public function edit(BranchStore $branch)
    {
        return view('admin.branches.form', compact('branch'));
    }

    public function update(Request $request, BranchStore $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branch_stores,code,' . $branch->id,
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        $branch->update($request->all());

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch berhasil diupdate.');
    }

    public function destroy(BranchStore $branch)
    {
        $branch->status = 'deleted';
        $branch->save();
        // $branch->delete();

        return redirect()->route('super-admin.branches.index')->with('success', 'Branch berhasil dihapus.');
    }
}
