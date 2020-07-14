<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Clothing', 'Footwear', 'Accessories', 'T Shirts', 'Trainers', 'Essentials']),
        'weather' => $faker->randomElement(['clear', 'isolated-clouds', 'overcast', 'light-rain']),
        'slug' => $faker->randomElement(['clothing', 'footwear']),
    ];
});
