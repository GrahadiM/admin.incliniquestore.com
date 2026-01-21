<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage News
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @endpush

    <div class="px-2 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">News</h2>
            <div class="flex gap-2">
                <a href="{{ route('super-admin.news.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Tambah Berita
                </a>
                <a href="{{ route('super-admin.news.analytics') }}" class="bg-green-600 text-white px-4 py-2 rounded">
                    Analytics
                </a>
            </div>
        </div>

        <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg p-4">
            <table id="news-table" class="display w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Slug</th>
                        <th>Unggulan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->thumbnail)
                                    <img src="{{ asset('storage/'.$item->thumbnail) }}" class="w-16 rounded">
                                @endif
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>
                                @if($item->is_featured)
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded border border-green-300">Yes</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded border border-red-300">No</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'published')
                                    <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded border border-green-300">Published</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded border border-red-300">Draft</span>
                                @endif
                            </td>
                            <td class="flex gap-2">
                                <a href="{{ route('super-admin.news.show',$item) }}" class="bg-blue-600 px-2 py-1 text-white rounded text-sm">Lihat</a>
                                <a href="{{ route('super-admin.news.edit',$item) }}" class="bg-yellow-400 px-2 py-1 text-white rounded text-sm">Edit</a>
                                <form action="{{ route('super-admin.news.destroy',$item) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-600 px-2 py-1 text-white rounded text-sm">Hapus</button>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $('#news-table').DataTable();

            $('.delete-form').submit(function(e){
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Yakin hapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((r)=>{
                    if(r.isConfirmed) form.submit();
                })
            });

            @if(session('success'))
            Swal.fire({
                toast:true,
                position:'top-end',
                icon:'success',
                title:"{{ session('success') }}",
                timer:3000,
                showConfirmButton:false
            });
            @endif
        </script>
    @endpush
</x-app-layout>
