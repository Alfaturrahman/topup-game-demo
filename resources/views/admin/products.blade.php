@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-3">Kelola Nominal Top-Up</h2>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Produk</button>

    <table id="product-table" class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Label</th>
                <th>Harga (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->label }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    <button 
                        class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-id="{{ $product->id }}"
                        data-label="{{ $product->label }}"
                        data-price="{{ $product->price }}">
                        Edit
                    </button>
                    <button 
                        class="btn btn-sm btn-danger"
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

<!-- Tambah Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.products.store') }}" method="POST" class="modal-content">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Label</label>
                <input type="text" name="label" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="price" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-success">Simpan</button>
        </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" method="POST" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">Edit Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Label</label>
                <input type="text" name="label" id="editLabel" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="price" id="editPrice" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="deleteForm" method="POST" class="modal-content">
        @csrf
        @method('DELETE')
        <div class="modal-header">
            <h5 class="modal-title text-danger">Hapus Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            Apakah Anda yakin ingin menghapus produk ini?
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button class="btn btn-danger">Hapus</button>
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
