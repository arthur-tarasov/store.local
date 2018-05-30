<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "city";

    protected $fillable = [
        "name", "slug"
    ];

    public $timestamps = true;

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'Product_City', 'city_id', 'product_id')->withPivot('quantity', 'price');
    }
}
