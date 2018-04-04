<?php

use Illuminate\Database\Seeder;

class StoresUsersTableSeeder extends Seeder
{
	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i < 19; $i++) {
            array_push($data, [
                'store_id' => $i,
                'user_id' => 1,
                'role' => 1
            ]);
        }
        
        DB::table('stores_users')->insert($data);
    }
}