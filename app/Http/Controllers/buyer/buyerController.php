<?php

namespace App\Http\Controllers\buyer;

use App\buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class buyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = buyer::has('transactions')->get();
        return $this->showAll($buyers);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(buyer $buyer)
    {
        // $buyer = buyer::has('transactions')->findOrFail($id);
        return $this->showOne($buyer);
    }

   }
