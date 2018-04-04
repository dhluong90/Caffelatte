<?php

use Illuminate\Database\Seeder;

class ProductionUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'nguyen trong nghia',
                'email' => 'nguyentrongnghia77@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123
                'phone' => '01667597767',
                'image' => '',
                'role' => 1
            ]
        ]);
    }
}
