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
                    @foreach ($products as $product)
                        <div onclick="selectAmount({{ $product->discount_price ?? $product->price }})"
                            class="nominal-card border border-gray-300 hover:border-blue-500 cursor-pointer rounded p-3 text-center transition relative">

                            <p class="font-semibold">{{ $product->label }} Koin</p>

                            @if($product->discount_price)
                                <p class="text-sm text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-sm text-red-600 font-bold">
                                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                </p>
                                <span class="absolute bg-yellow-400 text-black text-xs px-3 py-0.5 rounded-bl shadow"
                                    style="top: 10px; right: -20px; transform: rotate(25deg); transform-origin: top right; width: 70px; text-align: center; font-style: italic;">
                                    {{ $product->event_name ?? 'Diskon' }}
                                </span>

                            @else
                                <p class="text-sm text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @endif

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
