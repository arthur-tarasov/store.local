<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = "products";

    protected $fillable = [
        "name", "slug"
    ];

    public $timestamps = true;

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_category', 'product_id', 'category_id');
    }
    public function cities()
    {
        return $this->belongsToMany('App\Models\City', 'product_city', 'product_id', 'city_id')->withPivot('quantity', 'price');
    }
}
