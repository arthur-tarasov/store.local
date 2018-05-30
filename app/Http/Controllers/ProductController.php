<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($category_name, Request $request) {

        $category = Category::where('slug', '=', $category_name)->first();

        $productsAll = $category->products()->get();

        $subCategories = Category::where('parent_id', '=', $category->id)->get();
        $products = null;
        if(count($subCategories) > 0) {

            foreach ($subCategories as $subCategory) {

                $currentSubcategoriesProducts = $subCategory->products()->get();
                foreach ($currentSubcategoriesProducts as $currentSubcategoriesProduct) {
                    $productsAll->add($currentSubcategoriesProduct);
                }

            }
        } else {
            $products = $productsAll;
        }

        $products = $productsAll->unique('id');

        $cities = array();
        $resultProducts = array();
        $defaultCity = "kiev";
        foreach ($products as $product) {
           $product->url = $_ENV["APP_URL"]."catalog/".$product->slug;
           $arrayStock = array();

           foreach ($product->cities as $city) {
               if ($request->city != null) {
                   if ($request->city == $city->slug) {
                       array_push($resultProducts, $product);
                   }
               } else {
                   if ($defaultCity == $city->slug) {
                       array_push($resultProducts, $product);
                   }
               }
               if ($request->city == $city->slug || $defaultCity  == $city->slug) {
                   array_push($arrayStock, array(
                       "name" => $city->name,
                       "slug" => $city->slug,
                       "quantity" => $city->pivot->quantity,
                       "price" => $city->pivot->price
                   ));
               }

               /**
                * last response
                */
               if(!in_array(["name" => $city->name,"slug" => $city->slug], $cities) ) {
                   array_push($cities, ["name" => $city->name,"slug" => $city->slug]);
               }

           }
           $product->stock = $arrayStock;

        }


          $collectionProducts = collect($resultProducts);
         $sorted = $collectionProducts->sortBy('name')->values();
        $sortedProducts = null;
        if ($request->sort != null) {

            switch ($request->sort) {
                case "price_asc": {
                    $sortedProducts = $sorted->sortBy(function ($product, $key) {
                       // return $product['stock'];

                        foreach ($product->stock as $stockItem) {

                            return $stockItem["price"] ;
                        }
                    })->values();
                    break;
                }
                case "price_desc": {
                    $sortedProducts = $sorted->sortByDesc(function ($product, $key) {
                        // return $product['stock'];

                        foreach ($product->stock as $stockItem) {

                            return $stockItem["price"] ;
                        }
                    })->values();
                    break;
                }
            }
        } else {
            $sortedProducts = $sorted;
        }

        foreach ($sortedProducts as $sortedProduct) {
            $arrayStock = array();
            foreach ($sortedProduct->cities as $city) {

                if($request->city != null) {
                    if ($request->city != $city->slug) {
                        array_push($arrayStock, array(
                            "name" => $city->name,
                            "slug" => $city->slug,
                            "quantity" => $city->pivot->quantity,
                            "price" => $city->pivot->price
                        ));
                    }
                } else {
                    if ($defaultCity != $city->slug) {
                        array_push($arrayStock, array(
                            "name" => $city->name,
                            "slug" => $city->slug,
                            "quantity" => $city->pivot->quantity,
                            "price" => $city->pivot->price
                        ));
                    }
                }


            }
            $sortedProduct->stock = array_merge($sortedProduct->stock, $arrayStock);
        }

        $breadcrumbs = array();
        $uri = explode( '/', $request->decodedPath());
        array_push($breadcrumbs, array(
            "name" => "Главная",
            "url" => "http://".$request->getHost()
        ));
        for ($i=0; $i < count($uri); $i++) {
            if ($uri[$i] == "catalog") {
                array_push($breadcrumbs, array(
                    "name" => "Каталог",
                    "url" => "http://".$request->getHost()."/catalog"
                ));
            } else {
                $categoryBread = Category::where('slug', '=', $uri[$i])->first();
                array_push($breadcrumbs, array(
                    "name" => $categoryBread->name,
                    "url" => "http://".$request->getHost()."/catalog/".$categoryBread->slug
                ));

            }

        }

        foreach ($subCategories as $subCategory) {
            $subCategory->url = "http://".$request->getHost()."/catalog/".$subCategory->slug;
        }
        return response()->json(["products" => $sortedProducts, "child_categories" => $subCategories, "breadcrumbs" => $breadcrumbs, "cities" => $cities]);

    }
}
