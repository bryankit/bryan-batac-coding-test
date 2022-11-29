<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductValidationRequest;
use App\Libraries\ResponseLibrary;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function __construct(private ProductService $productService){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        return ResponseLibrary::GetResponse($this->productService->getAllProducts());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $product) : JsonResponse
    {
        return ResponseLibrary::GetResponse($this->productService->getProductById($product));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductValidationRequest $request) : JsonResponse
    {
        return ResponseLibrary::GetResponse($this->productService->createProduct($request));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $productID, ProductValidationRequest $request) : JsonResponse
    {
        return ResponseLibrary::GetResponse($this->productService->updateProduct($productID, $request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $productID) : JsonResponse
    {
        return ResponseLibrary::GetResponse($this->productService->deleteProduct($productID));
    }
}
