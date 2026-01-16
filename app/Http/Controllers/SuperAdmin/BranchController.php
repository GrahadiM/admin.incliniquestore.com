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
        $request->validate(
            [
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
            ],
            [
                'name.required' => 'Nama cabang wajib diisi.',
                'name.string' => 'Nama cabang harus berupa teks.',
                'name.max' => 'Nama cabang maksimal 255 karakter.',

                'code.required' => 'Kode cabang wajib diisi.',
                'code.string' => 'Kode cabang harus berupa teks.',
                'code.max' => 'Kode cabang maksimal 50 karakter.',
                'code.unique' => 'Kode cabang sudah digunakan, silakan gunakan kode lain.',

                'phone.string' => 'Nomor telepon harus berupa teks.',
                'phone.max' => 'Nomor telepon maksimal 20 karakter.',

                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email maksimal 255 karakter.',

                'latitude.string' => 'Latitude harus berupa teks.',
                'latitude.max' => 'Latitude maksimal 50 karakter.',

                'longitude.string' => 'Longitude harus berupa teks.',
                'longitude.max' => 'Longitude maksimal 50 karakter.',

                'address.string' => 'Alamat harus berupa teks.',

                'city.string' => 'Nama kota harus berupa teks.',
                'city.max' => 'Nama kota maksimal 100 karakter.',

                'province.string' => 'Nama provinsi harus berupa teks.',
                'province.max' => 'Nama provinsi maksimal 100 karakter.',

                'country.string' => 'Nama negara harus berupa teks.',
                'country.max' => 'Nama negara maksimal 100 karakter.',

                'postal_code.string' => 'Kode pos harus berupa teks.',
                'postal_code.max' => 'Kode pos maksimal 20 karakter.',

                'status.required' => 'Status wajib dipilih.',
                'status.in' => 'Status yang dipilih tidak valid.'
            ],
            [
                'name' => 'Nama Cabang',
                'code' => 'Kode Cabang',
                'phone' => 'Nomor Telepon',
                'email' => 'Email',
                'latitude' => 'Latitude',
                'longitude' => 'Longitude',
                'address' => 'Alamat',
                'city' => 'Kota',
                'province' => 'Provinsi',
                'country' => 'Negara',
                'postal_code' => 'Kode Pos',
                'status' => 'Status'
            ]
        );

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
        $request->validate(
            [
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
            ],
            [
                'name.required' => 'Nama cabang wajib diisi.',
                'name.string' => 'Nama cabang harus berupa teks.',
                'name.max' => 'Nama cabang maksimal 255 karakter.',

                'code.required' => 'Kode cabang wajib diisi.',
                'code.string' => 'Kode cabang harus berupa teks.',
                'code.max' => 'Kode cabang maksimal 50 karakter.',
                'code.unique' => 'Kode cabang sudah digunakan, silakan gunakan kode lain.',

                'phone.string' => 'Nomor telepon harus berupa teks.',
                'phone.max' => 'Nomor telepon maksimal 20 karakter.',

                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email maksimal 255 karakter.',

                'latitude.string' => 'Latitude harus berupa teks.',
                'latitude.max' => 'Latitude maksimal 50 karakter.',

                'longitude.string' => 'Longitude harus berupa teks.',
                'longitude.max' => 'Longitude maksimal 50 karakter.',

                'address.string' => 'Alamat harus berupa teks.',

                'city.string' => 'Nama kota harus berupa teks.',
                'city.max' => 'Nama kota maksimal 100 karakter.',

                'province.string' => 'Nama provinsi harus berupa teks.',
                'province.max' => 'Nama provinsi maksimal 100 karakter.',

                'country.string' => 'Nama negara harus berupa teks.',
                'country.max' => 'Nama negara maksimal 100 karakter.',

                'postal_code.string' => 'Kode pos harus berupa teks.',
                'postal_code.max' => 'Kode pos maksimal 20 karakter.',

                'status.required' => 'Status wajib dipilih.',
                'status.in' => 'Status yang dipilih tidak valid.'
            ],
            [
                'name' => 'Nama Cabang',
                'code' => 'Kode Cabang',
                'phone' => 'Nomor Telepon',
                'email' => 'Email',
                'latitude' => 'Latitude',
                'longitude' => 'Longitude',
                'address' => 'Alamat',
                'city' => 'Kota',
                'province' => 'Provinsi',
                'country' => 'Negara',
                'postal_code' => 'Kode Pos',
                'status' => 'Status'
            ]
        );

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
