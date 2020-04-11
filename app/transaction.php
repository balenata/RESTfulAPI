<?php

namespace App;
use App\product;
use App\buyer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class transaction extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id',
        
    ];
    public function buyer(){
        return $this->belongsTo(buyer::class);

    }
    public function product(){
        return $this->belongsTo(product::class);
    }
    
}