<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getInventoryData()
    {
        return [
            'products' => $this->productRepo->getAllProducts(),
            'categories' => $this->productRepo->getAllCategories(),
        ];
    }

    public function storeProduct(array $data)
    {
        return $this->productRepo->createProduct($data);
    }

    public function removeProduct($id)
    {
        return $this->productRepo->deleteProduct($id);
    }
}
