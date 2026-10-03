<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function updateStock(Request $request, $id)
    {
        $targetId = $request->product_id ?? $id;

        $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($targetId);

        if ($request->type === 'out' && $product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk transaksi keluar!']);
        }

        if ($request->type === 'in') {
            $product->increment('stock', $request->quantity);
        } else {
            $product->decrement('stock', $request->quantity);
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Transaksi stok berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return back()->with('success', 'Produk berhasil dihapus!');
    }
}
