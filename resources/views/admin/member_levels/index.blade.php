<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Member Levels</h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    @endpush

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Member Levels</h2>
            <a href="{{ route('super-admin.member-levels.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah Level</a>
        </div>

        <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg p-4">
            <table id="levels-table" class="display nowrap w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jumlah User</th>
                        <th>Min Points</th>
                        <th>Min Purchase</th>
                        <th>Min Payment</th>
                        <th>Discount %</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($levels as $level)
                        <tr>
                            <td>{{ $level->id }}</td>
                            <td>{{ $level->name }}</td>
                            <td>{{ $level->users_count }}</td>
                            <td>{{ number_format($level->min_points) }}</td>
                            <td>{{ number_format($level->min_purchase) }}</td>
                            <td>Rp{{ number_format($level->min_payment, 0, ',', '.') }}</td>
                            <td>{{ $level->discount_percent }}%</td>
                            <td>
                                @if($level->status === 'active')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="flex gap-2">
                                <a href="{{ route('super-admin.member-levels.show', $level) }}" class="bg-blue-600 px-2 py-1 text-white rounded hover:bg-blue-700 text-sm">Lihat</a>
                                <a href="{{ route('super-admin.member-levels.edit', $level) }}" class="bg-yellow-400 px-2 py-1 text-white rounded hover:bg-yellow-500 text-sm">Edit</a>

                                <form action="{{ route('super-admin.member-levels.destroy', $level) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-600 px-2 py-1 text-white rounded hover:bg-red-700 text-sm delete-btn"
                                        {{-- @if($level->users->count() <= 0) disabled title="Level digunakan oleh user, tidak bisa dihapus" @endif --}}
                                    >
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

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                // DataTables
                $('#levels-table').DataTable({
                    // responsive: true,
                    columnDefs: [{ orderable: false, targets: 8 }], // non-orderable column "Aksi"
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

                // SweetAlert delete
                $('.delete-form').submit(function(e){
                    e.preventDefault();
                    const form = this;
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data level akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if(result.isConfirmed){
                            form.submit();
                        }
                    });
                });

                // SweetAlert notifikasi success / error
                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: "{{ session('success') }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: "{{ session('error') }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif
            });
        </script>
    @endpush
</x-app-layout>
