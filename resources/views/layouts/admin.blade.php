<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-white shadow-md w-64 p-6 fixed inset-y-0 left-0 z-40 transition-transform duration-200 ease-in-out"
               :class="{ '-translate-x-full': !sidebarOpen }">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
                <button class="md:hidden text-gray-500" @click="sidebarOpen = false">✕</button>
            </div>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.products') }}" class="flex items-center gap-3 p-3 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                        <i data-lucide="box" class="w-5 h-5"></i>
                        <span>Kelola Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 p-3 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                        <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                        <span>Daftar Pesanan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.income') }}" class="flex items-center gap-3 p-3 rounded-lg text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                        <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                        <span>Laporan Omset</span>
                    </a>
                </li>
            </ul>
            <div class="mt-10 text-sm text-gray-400 text-center">
                © {{ date('Y') }} Admin Panel
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 pl-0 md:pl-64 transition-all duration-300 ease-in-out">
            <!-- Top Bar -->
            <div class="p-4 bg-white shadow md:hidden flex justify-between items-center">
                <h2 class="text-lg font-semibold">Admin Panel</h2>
                <button @click="sidebarOpen = true" class="text-gray-500">☰</button>
            </div>

            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-500 text-white p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap 5 JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Lucide Init -->
    <script>
        lucide.createIcons();
    </script>

    <!-- DataTables Configuration -->
    <script>
        $(document).ready(function () {
            $('#orders-table').DataTable({
                order: [[0, 'desc']]
            });

            $('#income-table').DataTable({
                order: [[0, 'desc']]
            });

            $('#product-table').DataTable({
                order: [[1, 'asc']] // Assuming price is in column 2 (index 1)
            });
        });
    </script>
</body>
</html>
