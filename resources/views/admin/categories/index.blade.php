<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Categories</h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    @endpush

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Categories</h2>
            <a href="{{ route('super-admin.categories.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tambah Category
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg p-4">
            <table id="categories-table" class="display nowrap w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ ucfirst($category->status) }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td class="flex gap-2">
                                <a href="{{ route('super-admin.categories.show', $category) }}"
                                   class="bg-blue-600 px-2 py-1 text-white rounded hover:bg-blue-700 text-sm">
                                    Lihat
                                </a>

                                <a href="{{ route('super-admin.categories.edit', $category) }}"
                                   class="bg-yellow-400 px-2 py-1 text-white rounded hover:bg-yellow-500 text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('super-admin.categories.destroy', $category) }}"
                                      method="POST"
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 px-2 py-1 text-white rounded hover:bg-red-700 text-sm">
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
                $('#categories-table').DataTable({
                    columnDefs: [{ orderable: false, targets: 5 }],
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

                $('.delete-form').submit(function(e){
                    e.preventDefault();
                    const form = this;
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data category akan dihapus!",
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
