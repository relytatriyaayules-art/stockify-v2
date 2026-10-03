<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;

class ProductRepository
{
    public function getAllProducts()
    {
        return Product::with('category')->latest()->get();
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function deleteProduct($id)
    {
        return Product::destroy($id);
    }
}
