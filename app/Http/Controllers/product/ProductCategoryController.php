<?php

namespace App\Http\Controllers\Product;

use App\category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product , category $category)
    {
        $product->categories()->syncWithoutDetaching([$category->id]);
        // syncWithoutDetaching bo awaya data zyad bkait bo naw database mn datay 8 zyad akam wa agar 
        // dwbara 8 zyad bkam awa har 8 pehswy tyaya w 8 tr zyad nakat
        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, category $category)
    {
        if(!$product->categories()->find($category->id))
        {
            return $this->errorResponse('the specified categories is not a category of the product',404);
        }
        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }
}
