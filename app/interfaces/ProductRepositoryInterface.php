<?php

namespace App\interfaces;

interface ProductRepositoryInterface
{
    public function getAllProducts();

    public function getProductById(int $productId);

    public function createProduct(array $productDetails);

    public function updateProduct(int $productId, array $newDetails);

    public function deleteProduct(int $productId);
}
