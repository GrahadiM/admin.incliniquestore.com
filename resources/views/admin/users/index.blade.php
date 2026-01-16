<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    {{-- Styles DataTables --}}
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    @endpush

    <div class="px-2 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">{{ __('Manage Users') }}</h2>
            <a href="{{ route('super-admin.users.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                {{ __('Tambah User') }}
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg p-4">
            <table id="users-table" class="display nowrap stripe hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Branch</th>
                        <th>Member Level</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td>
                            <span class="px-3 py-1 text-xs font-semibold inline-flex items-center gap-1 bg-blue-100 text-blue-800 rounded border border-blue-300">
                                {{ ($user->branch?->code ?? '').' - '.($user->branch?->name ?? '') }}
                            </span>
                        </td>
                        <td>
                            @php
                                $levelName = strtolower($user->memberLevel?->name ?? '');

                                $levelStyles = [
                                    'copper' => 'bg-orange-100 text-orange-800 border border-orange-300',
                                    'silver' => 'bg-gray-100 text-gray-800 border border-gray-300',
                                    'gold' => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                                    'platinum' => 'bg-sky-100 text-sky-800 border border-sky-300',
                                    'diamond' => 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white',
                                    'master' => 'bg-gradient-to-r from-red-500 to-fuchsia-600 text-white'
                                ];

                                $badgeClass = $levelStyles[$levelName] ?? 'bg-slate-100 text-slate-600 border border-slate-300';
                            @endphp

                            <span class="px-3 py-1 text-xs font-semibold rounded inline-flex items-center gap-1 {{ $badgeClass }}">
                                {{ ucfirst($user->memberLevel?->name ?? '-') }}
                            </span>
                        </td>
                        <td>
                            @if($user->status === 'active')
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded border border-green-300">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded border border-red-300">Inactive</span>
                            @endif
                        </td>
                        <td class="flex gap-2">
                            @if (!empty($user->whatsapp))
                            <a href="http://wa.me/{{ $user->whatsapp }}" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm" target="_blank" rel="noopener noreferrer">
                                Chat
                            </a>
                            @endif
                            <a href="{{ route('super-admin.users.show', $user) }}" class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                                Lihat
                            </a>
                            <a href="{{ route('super-admin.users.edit', $user) }}" class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition text-sm">
                                Edit
                            </a>
                            <form action="{{ route('super-admin.users.destroy', $user) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm delete-btn">
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

    {{-- Scripts DataTables --}}
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

        <script>
            $(document).ready(function () {
                // DataTables init
                $('#users-table').DataTable({
                    // responsive: true,
                    columnDefs: [{ orderable: false, targets: 6 }], // non-orderable column "Aksi"
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

                // SweetAlert delete confirmation
                $('.delete-btn').click(function() {
                    const form = $(this).closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data user akan dihapus!",
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

                // SweetAlert toast success
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
