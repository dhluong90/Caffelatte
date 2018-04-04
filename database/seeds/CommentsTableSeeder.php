<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i < 10; $i++) {
            array_push($data, [
                'content' => 'hay hay hay' . ' - ' . $i,
                'user_id' => 1,
                'blog_id' => 2,
            ]);
        }

        DB::table('comments')->insert($data);   
    }
}
