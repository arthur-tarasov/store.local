<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call(ProductTableSeeder::class);

        $this->call(CategoryTableSeeder::class);
       $this->call(ProductCategoryTableSeeder::class);
        $this->call(CityTableSeeder::class);

        $this->call(ProductCityTableSeeder::class);
    }
}
