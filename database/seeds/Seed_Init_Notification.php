<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB as DB;

class Seed_Init_Notification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->insert([
            [
                'content' => 'Cốc cốc, tình yêu của đời bạn biết đâu đang ở rất gần. Đăng nhập để kết nối với một nửa yêu thương :).',
                'content_en' => 'Knock knock, the love of your life could be here. Login now to connect with your other half :).',
                'count' => 0,
            ], [
                'content' => 'Hôm nay là một ngày rất dài với bạn? Hãy thư giãn và tìm một người bạn để trò chuyện hen. Đăng nhập ngay :)!',
                'content_en' => 'It\'s been a long day for you? Why not relax and find someone nice to talk to. Login now :)!',
                'count' => 0,
            ], [
                'content' => 'Bạn muốn hẹn hò nhưng không tìm được ai phù hợp? Hãy để Cafe & Latte giúp bạn tìm cơ duyên hạnh phúc hen. Đăng nhập!',
                'content_en' => 'You wanna date but can\'t find someone among your social circle? Let us help. Login now!',
                'count' => 0,
            ], [
                'content' => 'Cuộc sống vốn bộn bề khó khăn. Vì vậy hãy mở lòng mình để thấy đời thật đẹp. Đăng nhập để tìm cho mình cơ duyên hạnh phúc :).',
                'content_en' => 'Life is already so hard, why should love be? Login!',
                'count' => 0,
            ], [
                'content' => 'Tình yêu là sự tin tưởng dành cho nhau. Và ông mai bà mối mong bạn có thể tìm được người bạn tin yêu. Đăng nhập :)!',
                'content_en' => 'Trust is what we focus on and we hope you can find someone you trust. Login!',
                'count' => 0,
            ], [
                'content' => 'Cafe cũng như tình yêu, có đắng có ngọt. Đăng nhập để chủ động tìm hạnh phúc cho mình.',
                'content_en' => 'Coffee can be bitter or sweet, you choose your type of coffee. Login to find your better half.',
                'count' => 0,
            ], [
                'content' => 'Ông mai bà mối mong bạn có thể tìm được một người khiến bạn cười mỗi ngày. Đăng nhập tìm một nửa yêu thương :).',
                'content_en' => 'We hope you\'ll find someone who can make you smile everyday. Login now to meet your better half.',
                'count' => 0,
            ]
        ]);

    }
}
