<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top-Up Higs Domino</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow-lg">
        <h1 class="text-xl font-semibold mb-4">Top-Up Higs Domino</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/topup') }}" method="POST">
            @csrf

            <label for="player_id" class="block text-sm font-medium text-gray-700">ID Pemain</label>
            <input type="text" name="player_id" id="player_id" class="w-full p-2 border rounded mt-2" placeholder="Masukkan ID Pemain" required>

            <label for="amount" class="block text-sm font-medium text-gray-700 mt-4">Nominal Top-Up (M)</label>
            <input type="number" name="amount" id="amount" class="w-full p-2 border rounded mt-2" placeholder="Masukkan jumlah" required>

            <label for="payment_method" class="block text-sm font-medium text-gray-700 mt-4">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="w-full p-2 border rounded mt-2" required>
                <option value="dana">Dana</option>
                <option value="ovo">OVO</option>
                <option value="gopay">GoPay</option>
            </select>

            <button type="submit" class="mt-4 w-full bg-blue-600 text-white p-2 rounded">Top-Up Sekarang</button>
        </form>
    </div>
</body>
</html>
