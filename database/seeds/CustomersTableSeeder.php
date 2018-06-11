<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = DB::table('users')->get();
        // var_dump($customers);
        foreach ($customers as $key => $value) {
            $customer = (array)$value;
            unset($customer['role']);
            DB::table('customers')->insert($customer);
        }
    }
}
