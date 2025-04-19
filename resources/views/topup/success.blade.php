<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top-Up Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-green-600 mb-4">✅ Top-Up Berhasil Dibuat!</h1>
        <p class="text-gray-700 mb-4">Silakan lanjutkan pembayaran sesuai metode yang kamu pilih.</p>

        @if (session('ref'))
            <p class="text-sm text-gray-600">Kode Transaksi:</p>
            <div class="text-lg font-mono text-blue-600 font-semibold mb-4">{{ session('ref') }}</div>

            <a href="{{ url('/simulate-payment/' . session('ref')) }}"
               class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                🔁 Simulasikan Pembayaran
            </a>
        @else
            <p class="text-red-500 font-medium">Kode transaksi tidak ditemukan.</p>
        @endif

        <div class="mt-6">
            <a href="{{ url('/topup') }}" class="text-blue-500 hover:underline text-sm">← Kembali ke halaman Top-Up</a>
        </div>
    </div>
</body>
</html>
