<?php

use App\category;
use App\product;
use App\transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();  // truncate bakar ahenret bo away har jarek ka table test krd dwbara bataly katawa
        category::truncate();
        product::truncate();
        transaction::truncate();
        DB::table('category_product')->truncate();

        $userQuantity = 1000;
        $categoryQuantity = 30;
        $productQuantity = 1000;
        $transactionQuantity = 1000;


        User::flushEventListeners();
        category::flushEventListeners();
        product::flushEventListeners();
        transaction::flushEventListeners();


        factory(User::class,$userQuantity)->create();

        factory(category::class,$categoryQuantity)->create();

        factory(product::class,$productQuantity)->create()->each(function($product){
            $categories = category::all()->random(mt_rand(1,5))->pluck('id');
            $product->categories()->attach($categories);
        });

        factory(product::class, $productQuantity)->create();

        factory(transaction::class , $transactionQuantity)->create();

    }
}
