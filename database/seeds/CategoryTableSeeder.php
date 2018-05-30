<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $index = 0;
        $step = 0;
        for ($i=1; $i <= 5; $i++) {

            $parent = Category::create(
                [
                    'name' => 'Category '.$i,
                    'slug' => str_slug('Category '.$i, '_')
                ]

            );


            for ($j=1; $j <= 3; $j++) {

                if($i == 1) {
                    $index = $i * 5 + $j;
                } else {
                    $index = $i * 5 + $j - $step;
                }

                Category::create(
                    [
                        'name' => 'Category '.($index),
                        'slug' => str_slug('Category '.($index), '_'),
                        'parent_id' => $parent->id
                    ]);
            }
            $step += 2;

        }
    }
}
