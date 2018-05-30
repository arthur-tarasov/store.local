<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$products = Product::all();
        $categories = Category::all();

        $countProducts = count($products);
        $countCouples = count($categories) / 2;

        $index = 0;
        for ($i=0; $i < $countProducts; $i++) {

            if($i%$countCouples == 0) {
                $index = 0;
            } else {
                $index+=2;
            }

            $products[$i]->categories()->attach([ $categories[$index]->id, $categories[$index + 1]->id ]);
        }*/

        $products = Product::all();
        $categories = Category::whereNotNull("parent_id")->get();

        $countProducts = count($products);
        $countCategories = count($categories);


        for ($i=0; $i < $countProducts; $i++) {
            $arrayIndex = array();
            $randCount = rand(0,3);
            for ($j=0; $j < $randCount; $j++) {
                $currentRandCategory =  $categories[rand(0, $countCategories - 1)]->id;
                if(!in_array($currentRandCategory, $arrayIndex))
                    array_push($arrayIndex, $currentRandCategory);

            }
            $products[$i]->categories()->attach($arrayIndex);

        }
    }
}
