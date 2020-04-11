<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\category;
use App\product;
use App\transaction;
use App\User;
use App\seller;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::VERIFIED_USER,User::UNVERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin' => $verified = $faker->randomElement([User::ADMIN_USER,User::REGULAR_USER]),
    ];
});
$factory->define(category::class, function (Faker\Generator $faker) {
   

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
       
    ];
});
$factory->define(product::class, function (Faker\Generator $faker) {
   

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement([product::AVAILABLE_PRODUCT,product::UNAVAILABLE_PRODUCT]),
        'image' => $faker->randomElement(['img1.jpg','img2.jpg','img3.jpg']),
        'seller_id' =>User::all()->random()->id, // that random used to select a random id in your database for test
        // User::inRandomOrder()->first()->id,
    ];
});
$factory->define(transaction::class, function (Faker\Generator $faker) {
   $seller =seller::has('products')->get()->random(); // aw get() bo awaya ka dyare bkait datakat chon betawa esta dyaet krdwa ka random bet
   $buyer =User::all()->except($seller->id)->random();

    return [
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id,
        'quantity' => $faker->numberBetween(1,3),
    ];
});
