@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Daftar Transaksi</h2>

<table id="orders-table" class="w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">Tanggal</th>
            <th class="p-3 text-left">ID Pemain</th>
            <th class="p-3 text-left">Nominal</th>
            <th class="p-3 text-left">Metode</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Ref</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                <td class="p-3">{{ $order->player_id }}</td>
                <td class="p-3">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                <td class="p-3">{{ strtoupper($order->payment_method) }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded text-white text-xs {{ $order->status === 'success' ? 'bg-green-500' : 'bg-yellow-500' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="p-3">{{ $order->merchant_ref ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center p-4 text-gray-500">Belum ada transaksi</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
