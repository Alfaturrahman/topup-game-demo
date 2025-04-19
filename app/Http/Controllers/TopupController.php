<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TopupController extends Controller
{
    public function showForm()
    {
        return view('topup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required',
            'amount' => 'required|integer',
            'payment_method' => 'required',
        ]);

        $transaction = Transaction::create([
            'player_id' => $request->player_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return redirect()->route('topup.form')->with('success', 'Transaksi berhasil disimpan!');
    }
}
