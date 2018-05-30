<?php

use App\Models\City;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        $cities = City::all();

        $countCities = count($cities);

        foreach ($products as $product) {
            $citiesProduct = array();
            $randCityArraySize = rand(0, $countCities);

            for ($j=0; $j < $randCityArraySize; $j++) {
                $currentRandCity =  $cities[rand(0, $countCities - 1)];
                if(!in_array($currentRandCity, $citiesProduct))
                    array_push($citiesProduct, $currentRandCity);
            }

            for ($j=0; $j < count($citiesProduct); $j++) {
                $product->cities()->attach($citiesProduct[$j]->id, [
                    "quantity" => rand(1, 100),
                    "price" => rand(10, 1000)
                ]);
            }
        }
    }
}
