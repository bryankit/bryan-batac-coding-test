<?php

namespace App\Services;

use App\interfaces\ProductRepositoryInterface;
use App\Libraries\ResponseLibrary;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public function __construct(private ProductRepositoryInterface $productRepository){}

    /**
     * Get All Products.
     *
     * @return array
     */
    public function getAllProducts() : array
    {
        try {
            $data = cache()->remember('product-page-' . request('page', 1), now()->addMinutes(5) ,function() {
                return $this->productRepository->getAllProducts();
            });
            return ResponseLibrary::SuccessResponse($data);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return ResponseLibrary::ErrorResponse($exception->getMessage());
        }
    }

    /**
     * Get Product by id.
     *
     * @param int $productId
     * @return array
     */
    public function getProductById(int $productId) : array
    {
        try {
            return ResponseLibrary::SuccessResponse($this->productRepository->getProductById($productId));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['data' => $productId]);
            return ResponseLibrary::ErrorResponse($exception->getMessage(), $productId);
        }
    }

    /**
     * Create Product.
     *
     * @param object $productDetails
     * @return array
     */
    public function createProduct(object $productDetails) : array
    {
        try {
            $validated = $productDetails->safe()->only(['product_name', 'product_description', 'product_price']);
            return ResponseLibrary::SuccessResponse($this->productRepository->createProduct($validated));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['data' => $validated]);
            return ResponseLibrary::ErrorResponse($exception->getMessage());
        }
    }

    /**
     * Update Products.
     *
     * @param int $productId
     * @param object $request
     * @return array
     */
    public function updateProduct(int $productId, object $productDetails) : array
    {
        try {
            $validated = $productDetails->safe()->only(['product_name', 'product_description', 'product_price']);
            return ResponseLibrary::SuccessResponse($this->productRepository->updateProduct($productId, $validated));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['data' => $validated]);
            return ResponseLibrary::ErrorResponse($exception->getMessage());
        }
    }

    /**
     * Delete Products.
     *
     * @param int $productId
     * @return array
     */
    public function deleteProduct(int $productId) : array
    {
        try {
            return ResponseLibrary::SuccessResponse($this->productRepository->deleteProduct($productId));
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), ['data' => $productId]);
            return ResponseLibrary::ErrorResponse($exception->getMessage());
        }
    }
}
