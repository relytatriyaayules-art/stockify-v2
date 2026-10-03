<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockOpnameLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $logs = StockOpnameLog::with(['user', 'product'])->latest()->get();
        return view('stock_opname.index', compact('products', 'logs'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'physical_stock' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $systemStock = $product->stock;
        $physicalStock = $request->physical_stock;
        $difference = $physicalStock - $systemStock;

        // Catat Log Opname
        StockOpnameLog::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'system_stock' => $systemStock,
            'physical_stock' => $physicalStock,
            'difference' => $difference,
            'notes' => $request->notes,
        ]);

        // Update stok fisik produk
        $product->update(['stock' => $physicalStock]);

        return back()->with('success', "Stock Opname berhasil! Produk '{$product->name}' disesuaikan dari {$systemStock} unit menjadi {$physicalStock} unit (Selisih: {$difference}).");
    }
}
