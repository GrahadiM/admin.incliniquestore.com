<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use App\Models\BranchStore;
use App\Models\MemberLevel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('branch', 'memberLevel', 'roles')->where('id', '!=', 1)->get();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $user = NULL;
        $branches = BranchStore::active()->get();
        $levels = MemberLevel::active()->get();
        $roles = Role::where('name', '!=', 'super-admin')->get();

        return view('admin.users.form', [
            'user' => $user,
            'branches' => $branches,
            'levels' => $levels,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|min:3|max:20|regex:/^[0-9]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
            'branch_store_id' => 'nullable|exists:branch_stores,id',
            'member_level_id' => 'nullable|exists:member_levels,id',
        ]);

        // Jika role = customer otomatis set member_level_id = Copper
        if ($request->role === 'customer') {
            $copperLevel = MemberLevel::where('name', 'Copper')->first();
            $request->merge(['member_level_id' => $copperLevel?->id]);
        }

        // Jika role = admin, hapus member_level_id
        if ($request->role === 'admin') {
            $request->merge(['member_level_id' => null]);
        }

        // Jika role = member, hapus branch_store_id
        if ($request->role === 'member') {
            $request->merge(['branch_store_id' => null]);
        }

        $user = User::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_store_id' => $request->branch_store_id,
            'member_level_id' => $request->member_level_id,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('super-admin.users.index')
                         ->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user)
    {
        $user->load('branch', 'memberLevel', 'roles');

        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        $branches = BranchStore::active()->get();
        $levels = MemberLevel::active()->get();
        $roles = Role::where('name', '!=', 'super-admin')->get();

        return view('admin.users.form', [
            'user' => $user,
            'branches' => $branches,
            'levels' => $levels,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|min:3|max:20|regex:/^[0-9]+$/',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|exists:roles,name',
            'branch_store_id' => 'nullable|exists:branch_stores,id',
            'member_level_id' => 'nullable|exists:member_levels,id',
        ]);

        if ($request->role === 'customer') {
            $copperLevel = MemberLevel::where('name', 'Copper')->first();
            $request->merge(['member_level_id' => $copperLevel?->id, 'branch_store_id' => null]);
        }

        if ($request->role === 'admin') {
            $request->merge(['member_level_id' => null]);
        }

        if ($request->role === 'member') {
            $request->merge(['branch_store_id' => null]);
        }

        $user->update([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'branch_store_id' => $request->branch_store_id,
            'member_level_id' => $request->member_level_id,
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('super-admin.users.index')
                         ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->status = 'inactive';
        $user->save();
        // $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
