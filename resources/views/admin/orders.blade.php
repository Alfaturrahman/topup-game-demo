@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Transaksi</h2>

@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif
<div class="overflow-x-auto">
    <table id="orders-table" class="min-w-full bg-white shadow rounded overflow-hidden text-gray-700">
        <thead class="bg-gray-100 border-b border-gray-300">
            <tr>
                <th class="p-4 text-left text-sm font-semibold">Tanggal</th>
                <th class="p-4 text-left text-sm font-semibold">ID Pemain</th>
                <th class="p-4 text-left text-sm font-semibold">Label</th>
                <th class="p-4 text-left text-sm font-semibold">Nominal</th>
                <th class="p-4 text-left text-sm font-semibold">Metode</th>
                <th class="p-4 text-left text-sm font-semibold">Status</th>
                <th class="p-4 text-left text-sm font-semibold">Ref</th>
                <th class="p-4 text-left text-sm font-semibold">Pengiriman</th>
                <th class="p-4 text-left text-sm font-semibold">Detail</th>
                <th class="p-4 text-left text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                @php
                    $statusClasses = [
                        'success' => 'bg-green-500',
                        'pending' => 'bg-yellow-500',
                        'failed' => 'bg-red-500',
                    ];
                    $statusClass = $statusClasses[$order->status] ?? 'bg-gray-400';
                @endphp
                <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                    <td class="p-4 text-sm">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                    <td class="p-4 text-sm">{{ $order->player_id }}</td>
                    <td class="p-4 text-sm">{{ $order->product->label ?? '-' }}</td>
                    <td class="p-4 text-sm font-semibold text-green-700">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                    <td class="p-4 text-sm uppercase">{{ $order->payment_method }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-white text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-sm" title="{{ $order->merchant_ref ?? 'Tidak ada referensi' }}">
                        {{ $order->merchant_ref ?? '-' }}
                    </td>
                    <td class="p-4 text-sm">
                        @if($order->status_pengiriman)
                            <span class="bg-green-100 text-green-700 px-2 py-1 text-xs rounded font-semibold">Terkirim</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 text-xs rounded font-semibold">Belum</span>
                        @endif
                    </td>
                    <td class="p-4 text-sm">
                        <button onclick="openDetail({{ $order->id }})" class="text-indigo-600 hover:underline text-sm">
                            👁️ Lihat
                        </button>
                    </td>

                    <td class="p-4 text-sm">
                        @if(!$order->status_pengiriman)
                            <button onclick="openModal({{ $order->id }})" class="text-blue-600 hover:underline text-sm">Konfirmasi</button>
                        @else
                            <span class="text-green-600 font-semibold text-sm">Selesai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center p-6 text-gray-400 italic">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded shadow-lg p-6 w-full max-w-md relative">
        <button onclick="closeModal()" class="absolute top-2 right-3 text-gray-500 text-xl">&times;</button>

        <h3 class="text-lg font-semibold mb-4">Konfirmasi Pengiriman</h3>
        <form id="modalForm" method="POST" enctype="multipart/form-data" action="">
            @csrf
            <input type="file" name="bukti_pengiriman" accept="image/*" required class="mb-4">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Bukti</button>
        </form>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden">
    <div class="fixed right-0 top-0 h-full w-full sm:w-96 bg-white shadow-lg overflow-y-auto p-6">
        <button onclick="closeDetail()" class="absolute top-2 right-3 text-gray-500 text-xl">&times;</button>
        <h3 class="text-xl font-semibold mb-4">Detail Transaksi</h3>
        <div id="detailContent" class="text-sm space-y-2 text-gray-800">
            <!-- Isi detail akan dimuat dengan JS -->
        </div>
    </div>
</div>

<script>
    const orders = @json($orders);

    function openDetail(id) {
        const order = orders.find(o => o.id === id);
        if (!order) return;

        let html = `
            <p><strong>Tanggal:</strong> ${new Date(order.created_at).toLocaleString()}</p>
            <p><strong>ID Pemain:</strong> ${order.player_id}</p>
            <p><strong>Produk:</strong> ${order.product?.label ?? '-'}</p>
            <p><strong>Nominal:</strong> Rp ${parseInt(order.amount).toLocaleString('id-ID')}</p>
            <p><strong>Metode Pembayaran:</strong> ${order.payment_method.toUpperCase()}</p>
            <p><strong>Status:</strong> ${order.status}</p>
            <p><strong>Ref:</strong> ${order.merchant_ref ?? '-'}</p>
            <p><strong>Status Pengiriman:</strong> ${order.status_pengiriman ? 'Terkirim' : 'Belum'}</p>
        `;

        if (order.status_pengiriman && order.bukti_pengiriman) {
            html += `
                <div class="mt-4">
                    <p class="font-semibold mb-1">Bukti Pengiriman:</p>
                    <img src="/storage/${order.bukti_pengiriman}" class="w-full rounded shadow border" alt="Bukti Pengiriman">
                </div>
            `;
        }

        document.getElementById('detailContent').innerHTML = html;
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>

<script>
    function openModal(id) {
        const form = document.getElementById('modalForm');
        form.action = `/admin/orders/${id}/upload-bukti`;
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('modal').classList.remove('flex');
    }
</script>
@endsection
