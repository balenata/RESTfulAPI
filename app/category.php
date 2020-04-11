<?php

namespace App;
use App\product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
    ];
    protected $hidden = [
        'pivot'
    ];

    public function product(){
        return $this->belongsToMany(product::class);
    }
}
