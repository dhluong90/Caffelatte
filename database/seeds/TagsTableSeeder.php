<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
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
                'name' => 'MÓN LẠ',
                'slug' => 'mon-la',
            ],
        	[
                'name' => 'MÓN NHÀ LÀM',
                'slug' => 'mon-nha-lam',
            ],
        	[
                'name' => 'RAU NHÀ TRỒNG',
                'slug' => 'rau-nha-trong',
            ],
        ]);    
    }
}
