<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Meal Type',
                'description' => 'Thể loại các món ăn ngon',
                'parent_id' => 0,
                'slug' => 'meal-type',
            ],
            [
                'name' => 'Appetizers & Snacks',
                'description' => 'Các đồ ăn nhanh',
                'parent_id' => 1,
                'slug' => 'appetizers-snacks',
            ],
            [
                'name' => 'Breakfast & Brunch',
                'description' => 'Các đồ ăn sáng',
                'parent_id' => 1,
                'slug' => 'breakfast-brunch',
            ],
            [
                'name' => 'Dessers',
                'description' => 'Các đồ ăn tráng miệng',
                'parent_id' => 1,
                'slug' => 'dessers',
            ],
            [
                'name' => 'Dinner',
                'description' => 'Các đồ ăn tối',
                'parent_id' => 1,
                'slug' => 'dinner',
            ],
            [
                'name' => 'Drinks',
                'description' => 'Các đồ uống',
                'parent_id' => 1,
                'slug' => 'drinks',
            ],
            [
                'name' => 'Ingredient',
                'description' => 'Thể loại các món ăn ngon',
                'parent_id' => 0,
                'slug' => 'ingredient',
            ],
            [
                'name' => 'Beef',
                'description' => 'Các đồ ăn nhanh',
                'parent_id' => 7,
                'slug' => 'beef',
            ],
            [
                'name' => 'Chicken',
                'description' => 'Các đồ ăn sáng',
                'parent_id' => 7,
                'slug' => 'chicken',
            ],
            [
                'name' => 'Pasta',
                'description' => 'Các đồ ăn tráng miệng',
                'parent_id' => 7,
                'slug' => 'pasta',
            ],
            [
                'name' => 'Pork',
                'description' => 'Các đồ ăn tối',
                'parent_id' => 7,
                'slug' => 'pork',
            ],
            [
                'name' => 'Salmon',
                'description' => 'Các đồ uống',
                'parent_id' => 7,
                'slug' => 'salmon',
            ],
            [
                'name' => 'Diet & Health',
                'description' => 'Thể loại các món ăn ngon',
                'parent_id' => 0,
                'slug' => 'diet-health',
            ],
            [
                'name' => 'Diabetic',
                'description' => 'Các đồ ăn nhanh',
                'parent_id' => 13,
                'slug' => 'diabetic',
            ],
            [
                'name' => 'Gluten Free',
                'description' => 'Các đồ ăn sáng',
                'parent_id' => 13,
                'slug' => 'gluten',
            ],
            [
                'name' => 'Healthy',
                'description' => 'Các đồ ăn tráng miệng',
                'parent_id' => 13,
                'slug' => 'healthy',
            ],
            [
                'name' => 'Low calorie',
                'description' => 'Các đồ ăn tối',
                'parent_id' => 13,
                'slug' => 'low-calorie',
            ],
            [
                'name' => 'Low Fat',
                'description' => 'Các đồ uống',
                'parent_id' => 13,
                'slug' => 'low-fat',
            ],
        ]);  
    }
}
