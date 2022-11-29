<?php

namespace App\Repositories;

use App\interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        return Product::paginate(10);
    }

    public function getProductById($productId)
    {
        return Product::findOrFail($productId);
    }

    public function createProduct(array $productDetails)
    {
        return Product::create($productDetails);
    }

    public function updateProduct($productId, array $newDetails)
    {
        return Product::whereId($productId)->update($newDetails);
    }

    public function deleteProduct($productId)
    {
        return Product::destroy($productId);
    }
}
