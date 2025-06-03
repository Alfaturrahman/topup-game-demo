<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Kelola Top-Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-6xl mx-auto mt-10 bg-white p-8 rounded shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-center">Dashboard Admin - Kelola Top-Up</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 p-2">ID Transaksi</th>
                <th class="border border-gray-300 p-2">ID Pemain</th>
                <th class="border border-gray-300 p-2">Nominal</th>
                <th class="border border-gray-300 p-2">Harga (Rp)</th>
                <th class="border border-gray-300 p-2">Metode Pembayaran</th>
                <th class="border border-gray-300 p-2">Status</th>
                <th class="border border-gray-300 p-2">Tanggal</th>
                <th class="border border-gray-300 p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topups as $topup)
            <tr class="text-center">
                <td class="border border-gray-300 p-2">{{ $topup->id }}</td>
                <td class="border border-gray-300 p-2">{{ $topup->player_id }}</td>
                <td class="border border-gray-300 p-2">{{ number_format($topup->amount / 1000, 0) }} Koin</td>
                <td class="border border-gray-300 p-2">Rp {{ number_format($topup->amount, 0, ',', '.') }}</td>
                <td class="border border-gray-300 p-2 capitalize">{{ $topup->payment_method }}</td>
                <td class="border border-gray-300 p-2">
                    @if($topup->status == 'pending')
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @elseif($topup->status == 'confirmed')
                        <span class="text-green-600 font-semibold">Confirmed</span>
                    @else
                        <span class="text-red-600 font-semibold">{{ ucfirst($topup->status) }}</span>
                    @endif
                </td>
                <td class="border border-gray-300 p-2">{{ $topup->created_at->format('d-m-Y H:i') }}</td>
                <td class="border border-gray-300 p-2">
                    @if($topup->status == 'pending')
                        <form action="{{ url('/admin/topups/'.$topup->id.'/confirm') }}" method="POST" onsubmit="return confirm('Konfirmasi transaksi ini?')">
                            @csrf
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Konfirmasi</button>
                        </form>
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="p-4 text-center text-gray-500">Belum ada transaksi top-up</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
