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
        $product = Product::findOrFail($id);

        // Simpan perubahan produk utama
        $product->update($request->only('label', 'price'));

        // Jika admin centang "update semua"
        if ($request->has('update_all')) {
            $newLabel = strtolower($request->label);
            $newPrice = (int) $request->price;

            // Fungsi parsing label: "100m" => 0.1, "2.5b" => 2.5
            $parseLabel = function ($label) {
                if (preg_match('/^([\d.]+)([mb])$/i', strtolower($label), $match)) {
                    $value = (float) $match[1];
                    $unit = strtolower($match[2]);
                    return $unit === 'b' ? $value : $value / 1000;
                }
                return null; // jika tidak sesuai format
            };

            $baseValue = $parseLabel($newLabel);

            if ($baseValue === null || $baseValue <= 0) {
                return back()->with('error', 'Label tidak valid. Gunakan format seperti "100m" atau "1.5b".');
            }

            // Ambil semua produk, update berdasarkan rasio dari produk yang diedit
            $products = Product::all();
            foreach ($products as $p) {
                $val = $parseLabel($p->label);
                if ($val !== null && $val > 0) {
                    $calculatedPrice = round(($val / $baseValue) * $newPrice);
                    $p->update(['price' => $calculatedPrice]);
                }
            }
        }

        return back()->with('success', 'Produk berhasil diperbarui.');
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
        $totalOrders = $orders->count(); // ✅ Menambahkan total pesanan

        return view('admin.income', compact('orders', 'totalIncome', 'totalOrders'));
    }

    public function applyBulkDiscount(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:100',
            'discount_percent' => 'required|numeric|min:1|max:100',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $percent = $request->discount_percent;
        $eventName = $request->event_name;

        $products = Product::whereIn('id', $request->product_ids)->get();

        foreach ($products as $product) {
            $originalPrice = $product->price;
            $discountedPrice = round($originalPrice * (1 - $percent / 100));

            $product->update([
                'discount_price' => $discountedPrice,
                'event_name' => $eventName,
            ]);
        }

        return back()->with('success', 'Diskon ' . $percent . '% berhasil diterapkan ke ' . count($products) . ' produk.');
    }

    public function removeDiscount($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'discount_price' => null,
            'event_name' => null,
        ]);

        return back()->with('success', 'Diskon produk berhasil dihapus.');
    }

}

