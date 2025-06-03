<?php

namespace App\Http\Controllers;
use App\Models\Transaction;

use Illuminate\Http\Request;

class TripayController extends Controller
{
    public function handleCallback(Request $request)
    {
        $data = $request->all();

        // Kalau mau validasi signature, uncomment di sini dan sesuaikan
        /*
        $privateKey = env('TRIPAY_PRIVATE_KEY_SANDBOX');
        $callbackSignature = $request->header('X-Callback-Signature');
        $calculatedSignature = hash_hmac('sha256', $request->getContent(), $privateKey);

        if ($callbackSignature !== $calculatedSignature) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }
        */

        // Karena sandbox payload ga ada 'event', skip pengecekan ini dulu
        // Jika environment live, pastikan cek event payment_status
        // if (!isset($data['event']) || $data['event'] !== 'payment_status') {
        //     return response()->json(['error' => 'Invalid event type'], 400);
        // }

        if (!isset($data['merchant_ref'])) {
            return response()->json(['error' => 'Missing merchant_ref'], 400);
        }

        $transaction = Transaction::where('merchant_ref', $data['merchant_ref'])->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Update status transaksi
        if (isset($data['status'])) {
            $transaction->status = $data['status']; // bisa PAID, FAILED, EXPIRED
        }
        
        $transaction->save();

        return response()->json(['success' => true]);
    }
}
