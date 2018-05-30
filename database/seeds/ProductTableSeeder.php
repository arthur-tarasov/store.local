<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        for ($i=1; $i <= 100; $i++) {
            Product::create(
                [
                    'name' => "Tovar ".$i,
                    'slug' => str_slug("Tovar ".$i, '_')
                ]

            );
        }

    }
}
