<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        $totalAsset = $products->sum(function($p) {
            return $p->stock * $p->price;
        });

        return view('reports.index', compact('products', 'totalProducts', 'totalStock', 'totalAsset'));
    }
}
