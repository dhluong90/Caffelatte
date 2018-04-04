<?php

use Illuminate\Database\Seeder;

class TagsUpdateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'name' => 'MÓN NHÀ NẤU',
                'slug' => 'mon-nha-nau',
            ],
        ]);
    }
}
