<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return back()->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Supplier::destroy($id);
        return back()->with('success', 'Supplier berhasil dihapus!');
    }
}
