<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100">
    <div class="flex">
        <aside class="w-64 bg-white h-screen shadow-md p-6">
            <h1 class="text-xl font-bold mb-6">Admin Panel</h1>
            <ul class="space-y-2">
                <li><a href="{{ route('admin.products') }}" class="text-blue-600">Kelola Produk</a></li>
                <li><a href="{{ route('admin.orders') }}" class="text-blue-600">Daftar Pesanan</a></li>
                <li><a href="{{ route('admin.income') }}" class="text-blue-600">Laporan Omset</a></li>
            </ul>
        </aside>

        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap 5 JS + Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
        // Orders table - urut berdasarkan created_at DESC (misal kolom ke-0 atau 1 tergantung posisi)
        $('#orders-table').DataTable({
            order: [[0, 'desc']] // Ganti 0 sesuai posisi kolom created_at
        });

        // Income table - urut berdasarkan created_at DESC
        $('#income-table').DataTable({
            order: [[0, 'desc']] // Ganti 0 sesuai posisi kolom created_at
        });

        // Product table - urut berdasarkan price DESC
        $('#product-table').DataTable({
            order: [[1, 'asc']] // Ganti 1 jika kolom ke-1 berisi harga (price)
        });
    });

    </script>

</body>
</html>
