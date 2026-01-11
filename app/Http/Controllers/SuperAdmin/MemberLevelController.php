<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\MemberLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberLevelController extends Controller
{
    public function index()
    {
        $levels = MemberLevel::withCount('users')->get();
        return view('admin.member_levels.index', [
            'levels' => $levels
        ]);
    }

    public function create()
    {
        $level = null;
        return view('admin.member_levels.form', [
            'level' => $level
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:member_levels,name',
            'min_points' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'min_payment' => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        MemberLevel::create($request->all());

        return redirect()->route('super-admin.member-levels.index')
                         ->with('success', 'Member Level berhasil dibuat.');
    }

    public function show(MemberLevel $memberLevel)
    {
        return view('admin.member_levels.show', [
            'level' => $memberLevel
        ]);
    }

    public function edit(MemberLevel $memberLevel)
    {
        $level = $memberLevel;
        return view('admin.member_levels.form', [
            'level' => $level
        ]);
    }

    public function update(Request $request, MemberLevel $memberLevel)
    {
        $request->validate([
            'name' => 'required|string|unique:member_levels,name,' . $memberLevel->id,
            'min_points' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'min_payment' => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $memberLevel->update($request->all());

        return redirect()->route('super-admin.member-levels.index')
                         ->with('success', 'Member Level berhasil diupdate.');
    }

    public function destroy(MemberLevel $memberLevel)
    {
        if($memberLevel->users->count() > 0 || $memberLevel->users->count() != NULL)
            return back()->with('error', 'Member Level tidak dapat dihapus karena masih memiliki user.');

        $memberLevel->status = 'inactive';
        $memberLevel->save();
        // $memberLevel->delete();
        return back()->with('success', 'Member Level berhasil dihapus.');
    }
}
