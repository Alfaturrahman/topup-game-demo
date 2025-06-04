@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Kelola Nominal Top-Up</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button
            class="mb-6 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
            data-bs-toggle="modal"
            data-bs-target="#addModal">
            + Tambah Produk
        </button>
        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#discountModal">🎉 Atur Diskon / Event</button>
    </div>


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
                <td>
                    {{ $product->label }}
                    @if($product->event_name)
                        <span class="badge bg-warning text-dark ms-1">{{ $product->event_name }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold">
                    @if($product->discount_price && $product->discount_price < $product->price)
                        <span class="text-decoration-line-through text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <br>
                        <span class="text-danger">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                    @else
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    @endif
                </td>
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
                    @if($product->discount_price)
                        <form action="{{ route('admin.products.removeDiscount', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-3 py-1 rounded bg-warning text-dark hover:bg-yellow-400 transition text-xs" onclick="return confirm('Yakin ingin menghapus diskon produk ini?')">
                                Hapus Diskon
                            </button>
                        </form>
                    @endif
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
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="update_all" id="updateAllCheckbox">
                <label class="form-check-label" for="updateAllCheckbox">
                    Perbarui Otomatis Semua Produk
                </label>
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

<!-- Modal Diskon Multi Produk -->
<div class="modal fade" id="discountModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('admin.products.discount') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Atur Diskon / Event</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Event</label>
                <input type="text" name="event_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Diskon (%)</label>
                <input type="number" name="discount_percent" class="form-control" min="1" max="100" placeholder="Contoh: 15" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Pilih Produk</label>
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="product_ids[]" value="{{ $product->id }}" id="prod{{ $product->id }}">
                                <label class="form-check-label" for="prod{{ $product->id }}">
                                    {{ $product->label }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-warning">Terapkan Diskon</button>
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
