<?php

namespace App;

use App\Scopes\BuyerScope;
use App\transaction;

class buyer extends User
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope);
    }
    public function transactions(){
        return $this->hasMany(transaction::class);
    }
}
