<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Branches') }}
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    @endpush

    <div class="px-2 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">{{ __('Manage Branches') }}</h2>
            <a href="{{ route('super-admin.branches.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                {{ __('Tambah Branch') }}
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg p-4">
            <table id="branches-table" class="display nowrap stripe hover w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Phone</th>
                        {{-- <th>Email</th> --}}
                        <th>City</th>
                        {{-- <th>Province</th> --}}
                        {{-- <th>Country</th> --}}
                        {{-- <th>Postal Code</th> --}}
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                    <tr>
                        <td>{{ $branch->id }}</td>
                        <td>{{ $branch->name }}</td>
                        <td>{{ $branch->code }}</td>
                        <td>{{ $branch->phone ?? '-' }}</td>
                        {{-- <td>{{ $branch->email ?? '-' }}</td> --}}
                        <td>{{ $branch->city ?? '-' }}</td>
                        {{-- <td>{{ $branch->province ?? '-' }}</td> --}}
                        {{-- <td>{{ $branch->country ?? '-' }}</td> --}}
                        {{-- <td>{{ $branch->postal_code ?? '-' }}</td> --}}
                        <td>
                            @if($branch->status === 'active')
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded border border-green-300">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded border border-red-300">Inactive</span>
                            @endif
                        </td>
                        <td class="flex gap-2">
                            <a href="{{ route('super-admin.branches.show', $branch) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Lihat</a>
                            <a href="{{ route('super-admin.branches.edit', $branch) }}" class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">Edit</a>
                            <form action="{{ route('super-admin.branches.destroy', $branch) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm delete-btn">
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

        <script>
            $(document).ready(function () {
                $('#branches-table').DataTable({
                    // responsive: true,
                    columnDefs: [{ orderable: false, targets: 6 }], // non-orderable column "Aksi"
                    pageLength: 10,
                    lengthMenu: [10,25,50,100]
                });

                $('.delete-btn').click(function() {
                    const form = $(this).closest('form');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Branch akan dihapus!",
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
            });
        </script>
    @endpush
</x-app-layout>
