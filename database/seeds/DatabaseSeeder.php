<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);

        $categories = Category::all();
        Product::all()->each(function($product) use($categories){
            $product->categories()->attach(
                $categories->random(rand(1,2))->pluck('id')->toArray()
            );
        });
    }
}
