<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class TopupController extends Controller
{
    public function showForm()
    {
        $products = Product::orderBy('price')->get();
        return view('topup', compact('products'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required',
            'amount' => 'required|integer',
            'payment_method' => 'required',
        ]);

        // Buat merchant_ref unik
        $merchantRef = 'TOPUP-' . Str::upper(Str::random(10));

        // Simpan ke database (optional, bisa juga setelah berhasil request)
        $transaction = Transaction::create([
            'player_id' => $request->player_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'merchant_ref' => $merchantRef,
        ]);

        // Request ke Tripay
        $apiKey = "DEV-EUnLArWekqFALJ9K8hxad9Ef7nciSkBK0p4iJFJZ";
        $privateKey = "Rvu5O-EHVZ4-aD7Hj-iJQyh-snu61";
        $merchantCode = "T39300";

        $payload = [
            'method'         => $request->payment_method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $request->amount,
            'customer_name'  => 'Player ' . $request->player_id,
            'customer_phone' => $request->phone ?? '08123456789',  // nomor telepon contoh
            'customer_email' => $request->email ?? 'player@example.com', // email contoh
            'order_items'    => [
                [
                    'sku'      => 'domino-topup',
                    'name'     => 'Top-Up Higgs Domino',
                    'price'    => $request->amount,
                    'quantity' => 1,
                ]
            ],
            'callback_url'   => 'https://9b9b-2404-c0-5221-5f79-897a-a08f-e1a4-5683.ngrok-free.app/callback-tripay',
            'return_url'     => 'https://9b9b-2404-c0-5221-5f79-897a-a08f-e1a4-5683.ngrok-free.app/topup',
            'expired_time'   => time() + (60 * 60), // 1 jam
            'signature'      => hash_hmac('sha256', $merchantCode . $merchantRef . $request->amount, $privateKey),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey
        ])->withOptions(['verify' => false])->post('https://tripay.co.id/api-sandbox/transaction/create', $payload);
        

        if ($response->successful()) {
            $result = $response->json();
            return redirect($result['data']['checkout_url']);
        } else {
            return back()->with('error', 'Gagal membuat transaksi Tripay.');
        }
    }
}
