<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Vouchers
        </h2>
    </x-slot>

    {{-- Styles DataTables --}}
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    @endpush

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Manage Vouchers</h2>
            <a href="{{ route('super-admin.vouchers.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Tambah Voucher
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg p-4">
            <table id="vouchers-table" class="display nowrap stripe hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Nilai</th>
                        <th>Min Transaksi</th>
                        <th>Relasi</th>
                        <th>Kuota</th>
                        <th>Terpakai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $voucher)
                        <tr>
                            <td>{{ $voucher->id }}</td>
                            <td>{{ $voucher->code }}</td>
                            <td>{{ $voucher->name }}</td>
                            <td>
                                @if($voucher->type === 'percent')
                                    <span class="px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded">Percent</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Nominal</span>
                                @endif
                            </td>
                            <td>
                                @if($voucher->type === 'percent')
                                    {{ $voucher->value }}%
                                @else
                                    Rp{{ number_format($voucher->value, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>Rp{{ number_format($voucher->min_transaction, 0, ',', '.') }}</td>
                            <td>
                                @if($voucher->branchStore)
                                    <span class="text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                        Branch: {{ $voucher->branchStore->name }}
                                    </span>
                                @elseif($voucher->memberLevel)
                                    <span class="text-sm bg-purple-100 text-purple-800 px-2 py-1 rounded">
                                        Level: {{ $voucher->memberLevel->name }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $voucher->quota ?? '∞' }}</td>
                            <td>{{ $voucher->used }}</td>
                            <td>
                                @if($voucher->status === 'active')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="flex gap-2">
                                <a href="{{ route('super-admin.vouchers.show', $voucher) }}"
                                   class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                    Lihat
                                </a>

                                <a href="{{ route('super-admin.vouchers.edit', $voucher) }}"
                                   class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('super-admin.vouchers.destroy', $voucher) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            data-used="{{ $voucher->used }}"
                                            class="delete-btn px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                                            @if($voucher->used > 0) disabled title="Voucher sudah digunakan" @endif>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Scripts --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#vouchers-table').DataTable({
                    // responsive: true,
                    columnDefs: [{ orderable: false, targets: 10 }], // non-orderable column "Aksi"
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        },
                        zeroRecords: "Data tidak ditemukan"
                    }
                });

                // SweetAlert Delete
                $('.delete-btn').click(function() {
                    const form = $(this).closest('form');
                    const used = $(this).data('used');

                    if (used > 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tidak bisa dihapus',
                            text: 'Voucher sudah digunakan!'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Voucher akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                // Toast success
                @if(session('success'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                @endif

                // Toast error
                @if(session('error'))
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: "{{ session('error') }}",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                @endif
            });
        </script>
    @endpush
</x-app-layout>
