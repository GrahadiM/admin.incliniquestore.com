<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Voucher;
use App\Models\BranchStore;
use App\Models\MemberLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with(['branch', 'memberLevel'])->latest()->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $branches = BranchStore::where('status', 'active')->get();
        $levels   = MemberLevel::where('status', 'active')->get();

        return view('admin.vouchers.form', compact('branches', 'levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'            => 'required|unique:vouchers,code',
            'name'            => 'required|string|max:255',
            'type'            => ['required', Rule::in(['percent', 'amount'])],
            'value'           => 'required|numeric|min:0',
            'min_transaction' => 'nullable|numeric|min:0',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'quota'           => 'nullable|integer|min:1',
            'status'          => ['required', Rule::in(['active', 'inactive'])],
            'branch_store_id' => 'nullable|exists:branch_stores,id',
            'member_level_id' => 'nullable|exists:member_levels,id',
        ]);

        // ❗ Pastikan hanya salah satu yang diisi
        if ($request->branch_store_id && $request->member_level_id) {
            return back()->withErrors([
                'branch_store_id' => 'Voucher hanya boleh terkait ke salah satu: Branch atau Member Level.'
            ])->withInput();
        }

        Voucher::create([
            'code'            => $request->code,
            'name'            => $request->name,
            'type'            => $request->type,
            'value'           => $request->value,
            'min_transaction' => $request->min_transaction ?? 0,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'quota'           => $request->quota,
            'used'            => 0,
            'status'          => $request->status,
            'branch_store_id' => $request->branch_store_id,
            'member_level_id' => $request->member_level_id,
        ]);

        return redirect()
            ->route('super-admin.vouchers.index')
            ->with('success', 'Voucher berhasil ditambahkan');
    }

    public function show(Voucher $voucher)
    {
        $voucher->load(['branch', 'memberLevel']);
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        $branches = BranchStore::where('status', 'active')->get();
        $levels   = MemberLevel::where('status', 'active')->get();

        return view('admin.vouchers.form', compact('voucher', 'branches', 'levels'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code'            => 'required|unique:vouchers,code,' . $voucher->id,
            'name'            => 'required|string|max:255',
            'type'            => ['required', Rule::in(['percent', 'amount'])],
            'value'           => 'required|numeric|min:0',
            'min_transaction' => 'nullable|numeric|min:0',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'quota'           => 'nullable|integer|min:1',
            'status'          => ['required', Rule::in(['active', 'inactive'])],
            'branch_store_id' => 'nullable|exists:branch_stores,id',
            'member_level_id' => 'nullable|exists:member_levels,id',
        ]);

        // ❗ Pastikan hanya salah satu yang diisi
        if ($request->branch_store_id && $request->member_level_id) {
            return back()->withErrors([
                'branch_store_id' => 'Voucher hanya boleh terkait ke salah satu: Branch atau Member Level.'
            ])->withInput();
        }

        $voucher->update([
            'code'            => $request->code,
            'name'            => $request->name,
            'type'            => $request->type,
            'value'           => $request->value,
            'min_transaction' => $request->min_transaction ?? 0,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'quota'           => $request->quota,
            'status'          => $request->status,
            'branch_store_id' => $request->branch_store_id,
            'member_level_id' => $request->member_level_id,
        ]);

        return redirect()
            ->route('super-admin.vouchers.index')
            ->with('success', 'Voucher berhasil diperbarui');
    }

    public function destroy(Voucher $voucher)
    {
        if ($voucher->used > 0) {
            return back()->with('error', 'Voucher sudah digunakan dan tidak dapat dihapus');
        }

        $voucher->status = 'inactive';
        $voucher->save();
        // $voucher->delete();

        return redirect()
            ->route('super-admin.vouchers.index')
            ->with('success', 'Voucher berhasil dihapus');
    }
}
