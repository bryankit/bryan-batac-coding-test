<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_products_returns_a_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        Product::factory()->create([
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ]);

        $response = $this->getJson('/api/products', ['Accept' => 'application/json']);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->whereType('data', 'array')
                ->where('message', '' )
        );
        $response->assertStatus(201);
    }

    public function test_get_product_by_id_returns_a_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = Product::factory()->create([
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ]);

        $response = $this->getJson('/api/products/'. $product->id, ['Accept' => 'application/json']);
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('data', 'array')
                    ->where('message', '' )
            );
    }

    public function test_create_product_returns_a_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ];

        $response = $this->postJson('/api/products/create', $product, ['Accept' => 'application/json']);
        $response->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('data', 'array')
                    ->where('message', '' )
            );
    }

    public function test_create_product_missing_product_name_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ];

        $response = $this->postJson('/api/products/create', $product, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('errors', 'array')
                    ->where('message', 'The product name field is required.' )
            );
    }

    public function test_create_product_product_name_exceed_max_character_255_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_name'        => 'Lorem ipsum dolor sit amet, nonummy ligula volutpat hac integer nonummy. Suspendisse ultricies, congue etiam tellus, erat libero, nulla eleifend, mauris pellentesque. Suspendisse integer praesent vel, integer gravida mauris, fringilla vehicula lacinia nona',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ];

        $response = $this->postJson('/api/products/create', $product, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('errors', 'array')
                    ->where('message', 'The product name must not be greater than 255 characters.' )
            );
    }

    public function test_create_product_missing_product_description_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_name'        => 'product_name 1',
            'product_price'       => 99.99
        ];

        $response = $this->postJson('/api/products/create', $product, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('errors', 'array')
                    ->where('message', 'The product description field is required.' )
            );
    }

    public function test_create_product_product_price_not_a_number_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 'not int'
        ];

        $response = $this->postJson('/api/products/create', $product, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('errors', 'array')
                    ->where('message', 'The product price must be a number.' )
            );
    }

    public function test_create_product_product_price_missing_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
        ];

        $response = $this->postJson('/api/products/create', $product, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereType('errors', 'array')
                    ->where('message', 'The product price field is required.' )
            );
    }

    public function test_update_product_returns_a_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_name'        => 'product_name modified 1',
            'product_description' => 'product_description modified 1',
            'product_price'       => 66.66
        ];

        $productData = Product::factory()->create([
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ]);

        $response = $this->putJson('/api/products/update/' . $productData->id, $product, ['Accept' => 'application/json']);
        $response->assertStatus(201)
            ->assertExactJson([
                'message' => '',
                'data' => 1
            ]);
    }

    public function test_update_product_missing_parameters_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
        ];

        $productData = Product::factory()->create([
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ]);

        $response = $this->putJson('/api/products/update/' . $productData->id, $product, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertExactJson([
                'message' => 'The product name field is required. (and 2 more errors)',
                'errors' => [
                    'product_name'        => ['The product name field is required.'],
                    'product_description' => ['The product description field is required.'],
                    'product_price'       => ['The product price field is required.'],
                ]
            ]);
    }

    public function test_update_product_invalid_parameters_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $product = [
            'product_name'        => 'Lorem ipsum dolor sit amet, nonummy ligula volutpat hac integer nonummy. Suspendisse ultricies, congue etiam tellus, erat libero, nulla eleifend, mauris pellentesque. Suspendisse integer praesent vel, integer gravida mauris, fringilla vehicula lacinia nona',
            'product_description' => 'product_description modified 1',
            'product_price'       => 'invalid price'
        ];

        $productData = Product::factory()->create([
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ]);

        $response = $this->putJson('/api/products/update/' . $productData->id, $product, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertExactJson([
                'message' => 'The product name must not be greater than 255 characters. (and 1 more error)',
                'errors' => [
                    'product_name'        => ['The product name must not be greater than 255 characters.'],
                    'product_price'       => ['The product price must be a number.']
                ]
            ]);
    }

    public function test_delete_product_returns_a_successful_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $productData = Product::factory()->create([
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ]);

        $response = $this->deleteJson('/api/products/delete/' . $productData->id, ['Accept' => 'application/json']);
        $response->assertStatus(201)
            ->assertExactJson([
                'message' => '',
                'data' => 1
            ]);
    }

    public function test_delete_product_with_non_existent_id_returns_a_failure_response()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $productData = Product::factory()->create([
            'product_name'        => 'product_name 1',
            'product_description' => 'product_description 1',
            'product_price'       => 99.99
        ]);


        $response = $this->deleteJson('/api/products/delete/' . $productData->id + 1, ['Accept' => 'application/json']);
        $response->assertStatus(201)
            ->assertExactJson([
                'message' => '',
                'data' => 0
            ]);
    }



}
