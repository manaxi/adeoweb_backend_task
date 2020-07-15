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
        $this->call(CitiesTableSeeder::class);
        // Getting all categories from database
        $categories = Category::all();
        // Foreach category attaching 1 or 2 categories
        Product::all()->each(function($product) use($categories){
            $product->categories()->attach(
                $categories->random(rand(1,2))->pluck('id')->toArray()
            );
        });
    }
}
