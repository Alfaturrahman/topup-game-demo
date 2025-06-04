@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Transaksi</h2>

<table id="orders-table" class="min-w-full bg-white shadow rounded overflow-hidden text-gray-700">
    <thead class="bg-gray-100 border-b border-gray-300">
        <tr>
            <th class="p-4 text-left text-sm font-semibold cursor-pointer">Tanggal</th>
            <th class="p-4 text-left text-sm font-semibold cursor-pointer">ID Pemain</th>
            <th class="p-4 text-left text-sm font-semibold cursor-pointer">Nominal</th>
            <th class="p-4 text-left text-sm font-semibold cursor-pointer">Metode</th>
            <th class="p-4 text-left text-sm font-semibold cursor-pointer">Status</th>
            <th class="p-4 text-left text-sm font-semibold cursor-pointer">Ref</th>
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
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center p-6 text-gray-400 italic">Belum ada transaksi</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
