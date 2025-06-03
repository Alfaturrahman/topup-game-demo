@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Laporan Omset</h2>

<form method="GET" class="mb-6 flex flex-wrap items-end gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Dari Tanggal</label>
        <input type="date" name="from" value="{{ request('from') }}" class="p-2 border rounded">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Sampai Tanggal</label>
        <input type="date" name="to" value="{{ request('to') }}" class="p-2 border rounded">
    </div>
    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </div>
</form>

<div class="mb-6 bg-green-100 text-green-800 p-4 rounded font-semibold">
    Total Omset: Rp {{ number_format($totalIncome, 0, ',', '.') }}
</div>

<table id="income-table" class="w-full bg-white shadow rounded overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3 text-left">Tanggal</th>
            <th class="p-3 text-left">ID Pemain</th>
            <th class="p-3 text-left">Nominal</th>
            <th class="p-3 text-left">Metode</th>
            <th class="p-3 text-left">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                <td class="p-3">{{ $order->player_id }}</td>
                <td class="p-3">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                <td class="p-3">{{ strtoupper($order->payment_method) }}</td>
                <td class="p-3">{{ ucfirst($order->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center p-4 text-gray-500">Tidak ada data dalam rentang tanggal ini</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
