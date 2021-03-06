<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\product;
use App\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];
        $this->validate($request,$rules); // request arrayaki empty drwst akat ka ba dli xot datay te akait
        $data = $request->all();
        $data['status'] = product::UNAVAILABLE_PRODUCT;
        $data['image'] = $request->image->store(''); // this image could be any name
        $data['seller_id'] = $seller->id;
        $product = product::create($data);
        return $this->showOne($product);
        

    }

   

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, product $product)
    {
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in:' . product::AVAILABLE_PRODUCT . ',' . product::UNAVAILABLE_PRODUCT,
            'image' => 'image',
        ];
        $this->validate($request, $rules);
        $this->checkSeller($seller,$product);
        $product->fill($request->intersect([
            'name',
            'description',
            'quantity',
        ]));
        if($request->has('status'))
        {
            $product->status = $request->status;
            if($product->isAvailable() && $product->categories()->count() ==0)
            {
                return $this->errorResponse('An active product must have at least one category',409);
            }
        }
        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }
        if($product->isClean())
        {
            return $this->errorResponse('you need to specify a different value to update',422);
        }
        $product->save();
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller , product $product)
    {
        $this->checkSeller($seller,$product);
        Storage::delete($product->image);
        $product->delete();// am srinawaya katya wata hamishayy nya w atwany data srawaka bhenitawa
        return $this->showOne($product);
    }

    protected function checkSeller(Seller $seller , product $product)
    {
        if($seller->id != $product->seller_id)
        {
            throw new HttpException(422,'the specified seller is not the actual seller of the product');
        }
    }
}
