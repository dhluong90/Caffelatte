<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
                'phone' => '0917678422',
                'image' => '',
                'role' => 1
            ],
            [
                'name' => 'minh nguyen',
                'email' => 'minhnguyen@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123,
                'phone' => '01667810933',
                'image' => '',
                'role' => 4

            ],
            [
                'name' => 'tai liver',
                'email' => 'tailiver7@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123,
                'phone' => '01667810933',
                'image' => '',
                'role' => 4

            ],
            [
                'name' => 'nguyen trong nghia',
                'email' => 'nguyentrongnghia77534@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123,
                'phone' => '01667810933',
                'image' => '',
                'role' => 4

            ],
            [
                'name' => 'minh nguyen',
                'email' => 'minhnguyen43534@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123,
                'phone' => '01667810933',
                'image' => '',
                'role' => 4

            ],
            [
                'name' => 'tai liver',
                'email' => 'tailiver7543@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123,
                'phone' => '01667810933',
                'image' => '',
                'role' => 4

            ],
            [
                'name' => 'nguyen trong nghia',
                'email' => 'nguyentrongnghia77534354@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123,
                'phone' => '01667810933',
                'image' => '',
                'role' => 4

            ],
            [
                'name' => 'minh nguyen',
                'email' => 'minhnguyen4354334@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123,
                'phone' => '01667810933',
                'image' => '',
                'role' => 4

            ],
            [
                'name' => 'tai liver',
                'email' => 'tailiver75543543@gmail.com',
                'password' => '$2y$10$QC7An67rk5GnQ6agyL0VxehEXsEfPRwjILWqW/tqO.5DVxlqKUaHO', //123123
                'phone' => '01667810933',
                'image' => '',
                'role' => 4
            ]
        ]);
    }
}
