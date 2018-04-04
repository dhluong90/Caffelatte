<?php

use Illuminate\Database\Seeder;

class FoodsTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 40; $i++) {
            array_push($data, [
                'food_id' => $i,
                'tag_id' => rand(1, 4),
            ]);
        }

        DB::table('foods_tags')->insert($data);   
    }
}
    