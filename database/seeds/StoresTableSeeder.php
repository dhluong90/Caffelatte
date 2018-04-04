<?php

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        for ($i = 1; $i < 20; $i++) {
            array_push($data, [
                'name' => 'CÔNG TY CHẬU GHÉP TRỒNG RAU ABCD ' .  $i,
                'logo' => '',
                'introduction' => 'Cung cấp giải pháp trồng rau sân thượng hiệu quả nhất hiện nay. Chậu ghép trồng rau ABCD là sản phẩm độc quyền do ông Trần đình tri sáng chế và đã được đăng ký sở hữu trí tuệ',
                'status' => 1,
                'slug' => 'cong-ty-chau-ghep-trong-rau-abcd-'.$i,
                'address' => '107 Hiệp Bình, Thủ Đức, Ho Chi Minh city, Viet Nam',
                'phone' => '0961477522',
                'sector' => 'Lĩnh vực Nông Nghiệp',
                'open_time' => '09:00',
                'close_time' => '23:00',
                'email' => 'www.congtychaugheptrongrauabcd'.$i.'@gmail.com',
                'facebook' => 'www.facebook/congtychaugheptrongrauabcd'.$i.'.com',
                'site_url' => 'www.congtychaugheptrongrauabcd'.$i.'.com',
                'branch' => '["Chi nhánh Tân Bình","Chi nhánh Gò Vấp", "Chi nhánh Thủ Đức"]',
                'open_day' => '1',
                'close_day' => '6',
                'approved_at' => time(),
            ]);
        }

        DB::table('stores')->insert($data);    
    }
}
