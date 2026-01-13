<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Products
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    @endpush

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold">Products</h2>
            <a href="{{ route('super-admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                Tambah Product
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg p-4">
            <table id="products-table" class="display nowrap w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thumbnail</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Unggulan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}" class="w-16 rounded">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name }}</td>
                            <td>Rp{{ number_format($product->price,0,',','.') }}</td>
                            <td>
                                @if($product->is_featured)
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Yes</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">No</span>
                                @endif
                            </td>
                            <td>
                                @if($product->status === 'active')
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="flex justify-start gap-2">
                                <a href="{{ route('super-admin.products.show', $product) }}" class="bg-blue-600 px-2 py-1 text-white rounded text-sm">Lihat</a>
                                <a href="{{ route('super-admin.products.edit', $product) }}" class="bg-yellow-400 px-2 py-1 text-white rounded text-sm">Edit</a>
                                <form action="{{ route('super-admin.products.destroy', $product) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-600 px-2 py-1 text-white rounded text-sm">Hapus</button>
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
            $('#products-table').DataTable();

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
