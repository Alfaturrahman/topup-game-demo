<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top-Up Higgs Domino</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function selectAmount(amount) {
            document.getElementById('amount').value = amount;
            document.querySelectorAll('.nominal-card').forEach(card => {
                card.classList.remove('border-blue-500');
            });
            event.currentTarget.classList.add('border-blue-500');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">

    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Top-Up Higgs Domino Murah</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/topup') }}" method="POST">
            @csrf

            <!-- Section 1: Lengkapi Data Game -->
            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-4">1. Lengkapi Data Game</h2>
                <label class="block mb-2 font-medium">ID Pemain</label>
                <input type="text" name="player_id" required class="w-full p-2 border rounded" placeholder="Contoh: 123456789">
            </section>

            <!-- Section 2: Pilih Nominal Top-Up -->
            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-4">2. Pilih Nominal Top-Up</h2>
                <input type="hidden" name="amount" id="amount" required>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @php
                        $options = [
                            ['100m', 4000], ['200m', 8000], ['300m', 12000], ['400m', 16000],
                            ['500m', 20000], ['600m', 24000], ['700m', 28000], ['800m', 32000],
                            ['900m', 36000], ['1b', 40000], ['1.5b', 70000], ['2b', 80000],
                            ['2.5b', 125000], ['3b', 120000], ['4b', 160000], ['5b', 200000],
                            ['6b', 270000], ['7b', 315000], ['8b', 360000], ['10b', 400000]
                        ];
                    @endphp

                    @foreach ($options as [$label, $price])
                        <div onclick="selectAmount({{ $price }})"
                             class="nominal-card border border-gray-300 hover:border-blue-500 cursor-pointer rounded p-3 text-center transition">
                            <p class="font-semibold">{{ $label }} Koin</p>
                            <p class="text-sm text-gray-600">Rp {{ number_format($price, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Section 3: Pilih Metode Pembayaran -->
            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-4">3. Pilih Metode Pembayaran</h2>
                <select name="payment_method" required class="w-full p-2 border rounded">
                    <option value="">-- Pilih Metode --</option>
                    <option value="dana">DANA</option>
                    <option value="bca">BCA</option>
                    <option value="bni">BNI</option>
                    <option value="uob">UOB Tomorrow</option>
                    <option value="shopeepay">ShopeePay</option>
                </select>
            </section>

            <!-- Submit -->
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded font-semibold">Top-Up Sekarang</button>
        </form>
    </div>

</body>
</html>
