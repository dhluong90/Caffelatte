<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BlogsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(FoodsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(FoodsTagsTableSeeder::class);
        $this->call(FoodsCategoriesTableSeeder::class);
        $this->call(StoresUsersTableSeeder::class);
        $this->call(TagsUpdateTableSeeder::class);
    }
}
