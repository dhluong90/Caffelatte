<?php

use Illuminate\Database\Seeder;

class FoodsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 15; $i++) {
            array_push($data, [
                'food_id' => $i,
                'category_id' => rand(1, 25),
            ]);
        }

        /**/
        array_push($data, [
                'food_id' => 16,
                'category_id' => 16,
            ]);
        for ($i = 1; $i <= 7; $i++) {
            array_push($data, [
                'food_id' => $i,
                'category_id' => 16,
            ]);
        }
        DB::table('foods_categories')->insert($data);   
    }
}
    