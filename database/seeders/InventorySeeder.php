<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $cat1 = Category::create(['name' => 'Elektronik', 'description' => 'Perangkat elektronik gawai & perlengkapan']);
        $cat2 = Category::create(['name' => 'ATK', 'description' => 'Alat tulis kantor']);

        Product::create([
            'category_id' => $cat1->id,
            'code' => 'PRD-001',
            'name' => 'Laptop Asus Vivobook',
            'stock' => 15,
            'price' => 8500000,
        ]);

        Product::create([
            'category_id' => $cat2->id,
            'code' => 'PRD-002',
            'name' => 'Kertas A4 80gr Sidu',
            'stock' => 50,
            'price' => 45000,
        ]);
    }
}
