<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Black Umbrella', 'Pink Hat', 'Chair', 'Car', 'Computer', 'Gloves', 
        'Pants', 'Shirt', 'Table', 'Shoes', 'Hat', 'Plate', 'Knife', 'Bottle', 'Coat', 'Lamp', 'Keyboard', 
        'Bag', 'Bench', 'Clock', 'Watch', 'Wallet']),
        'sku' => $faker->unique()->randomNumber($nbDigits = 9),
        'price' => $faker->numberBetween(2, 180),
        'status' => $faker->randomElement(['1']),
    ];
});
