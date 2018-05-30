<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array("Kiev", "Kharkiv", "Odessa", "Lviv", "Zhytomyr");
        for ($i=0; $i < count($array); $i++) {
            City::create(
                [
                    "name" => $array[$i],
                    "slug" => str_slug($array[$i],"_")
                ]);
        }
    }

}
