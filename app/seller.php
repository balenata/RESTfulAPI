<?php

namespace App;
use App\product;
use App\Scopes\SellerScope;

class seller extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new SellerScope);
    }
    public function products(){
        return $this->hasMany(product::class);
    }
}
