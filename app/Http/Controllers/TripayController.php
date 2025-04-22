<?php

namespace App\Http\Controllers;
use App\Models\Transaction;

use Illuminate\Http\Request;

class TripayController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Mendapatkan data dari Tripay (misalnya status transaksi)
        $data = $request->all();
        
        // Cek status transaksi
        if ($data['status'] == 'success') {
            // Jika transaksi berhasil, lakukan sesuatu (misalnya update database)
            // Misalnya, update status transaksi di database
            $transaction = Transaction::where('transaction_id', $data['transaction_id'])->first();
            if ($transaction) {
                $transaction->status = 'success';
                $transaction->save();
            }
        } else {
            // Jika transaksi gagal atau status lainnya
            // Update status transaksi di database
            $transaction = Transaction::where('transaction_id', $data['transaction_id'])->first();
            if ($transaction) {
                $transaction->status = 'failed';
                $transaction->save();
            }
        }

        // Mengembalikan respons OK ke Tripay
        return response()->json(['status' => 'ok']);
    }
}
