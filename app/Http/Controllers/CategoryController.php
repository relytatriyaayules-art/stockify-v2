<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
