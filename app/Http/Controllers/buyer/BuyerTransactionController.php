<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // $b = Buyer::with('transactions')->findOrFail(14);
        $transaction = $buyer->transactions; // ama la regay property pey agat wata wak awaya blley 
        return $this->showAll($transaction); // la table buyer bro sar colunmny transaction 
    }

   
}
