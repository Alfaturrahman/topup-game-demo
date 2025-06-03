<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function products()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        Product::create($request->only('label', 'price'));
        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function updateProduct(Request $request, $id)
    {
        Product::findOrFail($id)->update($request->only('label', 'price'));
        return back()->with('success', 'Produk berhasil diperbarui');
    }

    // Method baru untuk hapus produk
    public function destroyProduct($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Produk berhasil dihapus');
    }

    public function orders()
    {
        $orders = Transaction::orderBy('created_at', 'DESC')->get();
        return view('admin.orders', compact('orders'));
    }

    public function income(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
        $to = $request->to ? Carbon::parse($request->to)->endOfDay() : now()->endOfMonth();

        $orders = Transaction::where('status', 'paid')
                        ->whereBetween('created_at', [$from, $to])
                        ->get();        
        $totalIncome = $orders->sum('amount');

        return view('admin.income', compact('orders', 'totalIncome'));
    }
}
