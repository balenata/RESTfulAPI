<?php

namespace App;
use App\category;
use App\transaction;
use App\seller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use SoftDeletes;
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';
     protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function isAvailable(){
        return $this->status == product::AVAILABLE_PRODUCT;
    }

    public function categories(){
        return $this->belongsToMany(category::class);
    }
    public function seller(){
        return $this->belongsTo(seller::class);
    }
    public function transactions(){
        return $this->hasMany(transaction::class);
    }
}
