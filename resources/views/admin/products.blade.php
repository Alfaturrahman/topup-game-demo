@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Kelola Nominal Top-Up</h2>

    <button
        class="mb-6 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
        data-bs-toggle="modal"
        data-bs-target="#addModal">
        + Tambah Produk
    </button>

    <div class="overflow-x-auto bg-white shadow rounded-lg p-2">
        <table id="product-table" class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga (Rp)</th>
            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->label }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-centre text-green-700 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                <button
                    class="inline-flex items-center px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 transition text-xs"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal"
                    data-id="{{ $product->id }}"
                    data-label="{{ $product->label }}"
                    data-price="{{ $product->price }}">
                    Edit
                </button>
                <button
                    class="inline-flex items-center px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700 transition text-xs"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    data-id="{{ $product->id }}">
                    Hapus
                </button>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.products.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title font-semibold">Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Label</label>
                <input type="text" name="label" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>
        <div class="modal-footer flex justify-end gap-2 p-4 border-t">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editForm" method="POST" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title font-semibold">Edit Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Label</label>
                <input type="text" name="label" id="editLabel" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="editPrice" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="modal-footer flex justify-end gap-2 p-4 border-t">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteForm" method="POST" class="modal-content">
        @csrf
        @method('DELETE')
        <div class="modal-header">
            <h5 class="modal-title text-red-600 font-semibold">Hapus Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus produk ini?</p>
        </div>
        <div class="modal-footer flex justify-end gap-2 p-4 border-t">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('editLabel').value = button.getAttribute('data-label');
        document.getElementById('editPrice').value = button.getAttribute('data-price');
        document.getElementById('editForm').action = `/admin/products/${button.getAttribute('data-id')}`;
    });

    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('deleteForm').action = `/admin/products/${button.getAttribute('data-id')}`;
    });
});
</script>
@endsection
