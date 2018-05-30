<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";

    protected $fillable = [
        "name", "slug", "parent_id"
    ];

    public $timestamps = true;

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_category', 'category_id', 'product_id');
    }
}
