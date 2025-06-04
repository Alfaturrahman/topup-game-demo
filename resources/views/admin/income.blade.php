@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-gray-800">Laporan Omset</h2>

<form method="GET" class="mb-8 flex flex-wrap items-end gap-6">
    <div class="flex flex-col">
        <label for="from" class="text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
        <input id="from" type="date" name="from" value="{{ request('from') }}" 
               class="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
    </div>
    <div class="flex flex-col">
        <label for="to" class="text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
        <input id="to" type="date" name="to" value="{{ request('to') }}" 
               class="border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
    </div>
    <div>
        <button type="submit" 
            class="bg-blue-600 text-white px-5 py-2 rounded-md shadow hover:bg-blue-700 transition">
            Filter
        </button>
    </div>
</form>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
    <!-- Card Total Omset -->
    <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500 flex items-center gap-5">
        <div class="p-4 rounded-full bg-green-100 text-green-600">
            <i data-lucide="dollar-sign" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-sm text-gray-600 mb-1 font-semibold uppercase tracking-wide">Total Omset</h3>
            <p class="text-3xl font-extrabold text-green-700">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Card Total Pesanan -->
    <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500 flex items-center gap-5">
        <div class="p-4 rounded-full bg-blue-100 text-blue-600">
            <i data-lucide="shopping-cart" class="w-7 h-7"></i>
        </div>
        <div>
            <h3 class="text-sm text-gray-600 mb-1 font-semibold uppercase tracking-wide">Total Pesanan</h3>
            <p class="text-3xl font-extrabold text-blue-700">{{ $totalOrders }} Pesanan</p>
        </div>
    </div>
</div>

<table id="income-table" class="min-w-full bg-white shadow rounded overflow-hidden text-gray-700">
    <thead class="bg-gray-100 border-b border-gray-300">
        <tr>
            <th class="p-4 text-left text-sm font-semibold">Tanggal</th>
            <th class="p-4 text-left text-sm font-semibold">ID Pemain</th>
            <th class="p-4 text-left text-sm font-semibold">Nominal</th>
            <th class="p-4 text-left text-sm font-semibold">Metode</th>
            <th class="p-4 text-left text-sm font-semibold">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
            <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                <td class="p-4 text-sm">{{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                <td class="p-4 text-sm">{{ $order->player_id }}</td>
                <td class="p-4 text-sm font-semibold text-green-700">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                <td class="p-4 text-sm uppercase">{{ $order->payment_method }}</td>
                <td class="p-4 text-sm capitalize">{{ $order->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center p-6 text-gray-400 italic">Tidak ada data dalam rentang tanggal ini</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
