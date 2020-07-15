<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRetrieveProduct()
    {
        $product = factory(Product::class)->create([
            'name' => 'Huawei watch',
            'price' => '200',
            'sku' => '153308796',
            'status' => '1',
            'categories' => ['2', '1'],
        ]);
        $this->json('GET', 'api/product/' . $product->id, [], [
            'Accept' => 'application/json'
        ])->assertStatus(200)
            ->assertJson([
                'name' => 'Huawei watch',
                'price' => '200',
                'sku' => '153308796',
                'status' => '1'
            ]);
    }
}
