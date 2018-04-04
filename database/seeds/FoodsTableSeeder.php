<?php

use Illuminate\Database\Seeder;

class FoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        

        for ($i = 1; $i < 60; $i++) {
            array_push($data, [
                'name' => ($i >= 40) ? 'món ăn' . $i : 'Lẩu nhúng cay ' . $i,
                'images' => '',
                'detail' => 'Thêm một món lẩu mới lạ với thịt bò, bạch tuột, ba rọi heo và đậu hủ non trong nước lẩu chua cay đậm đà. Các loại thịt được nhúng chín còn giữ nguyên vị ngọt, ăn kèm các loại rau như nấm, cải thảo, bông hành, ...',
                'status' => ($i <= 40) ? 1 : 0,
                'slug' => 'lau-nhung-cay-'.$i,
                'price' => '99000',
                'price_max' => '249000',
                'guides' => '',
                'steps' => '',
                'videos' => '["QzlGBslqLiQ","BtdSWl9vxAY","79S9Lv6LfqM"]',
                'store_id' => ''.$i,
                'approved_at' => time(),
                'user_id' => 1,
            ]);
        }
        for ($i = 1; $i < 20; $i++) {
            array_push($data, [
                'name' => ($i >= 40) ? 'món ăn' . $i : 'Lẩu nhúng cay ' . $i,
                'images' => '',
                'detail' => 'Thêm một món lẩu mới lạ với thịt bò, bạch tuột, ba rọi heo và đậu hủ non trong nước lẩu chua cay đậm đà. Các loại thịt được nhúng chín còn giữ nguyên vị ngọt, ăn kèm các loại rau như nấm, cải thảo, bông hành, ...',
                'status' => ($i <= 40) ? 1 : 0,
                'slug' => 'lau-nhung-cay-'.$i,
                'price' => '99000',
                'price_max' => '249000',
                'guides' => '',
                'steps' => '',
                'videos' => '["QzlGBslqLiQ","BtdSWl9vxAY","79S9Lv6LfqM"]',
                'store_id' => '16',
                'approved_at' => time(),
                'user_id' => 1,
            ]);
        }
        DB::table('foods')->insert($data);
    }
}
