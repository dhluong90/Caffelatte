<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Models\Dal\CustomerQModel;
use App\Http\Models\Dal\Notifications;

class NotificationSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send notifiaction every day';


    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->send_notification_everyday();
    }

    public function send_notification_everyday()
    {

        $list_customer_vi = CustomerQModel::get_users_fcm_token_with_language_and_country('vi_vn');
        $listGetViMessage = $list_customer_vi->pluck('fcm_token')->unique();

        $list_customer = CustomerQModel::get_users_fcm_token_with_language_and_country('');
        $listGetEnMessage = $list_customer->pluck('fcm_token')->unique();
        $listGetEnMessage = $listGetEnMessage->diff($listGetViMessage);

        $message = $this->get_notification_message();
        $notification = [
            'title' => 'Daily news',
            'body' => $message->content_en,
            'sound' => true
        ];

        $notification_vi = [
            'title' => 'Tin nhắn hàng ngày',
            'body' => $message->content,
            'sound' => true
        ];

        $fcmNotification = [
            'registration_ids' => $listGetEnMessage,
            'notification' => $notification,
        ];

        $headers = [
            'Authorization: key=AIzaSyA5PDF0tMDqid7fhD-cRC5PtroYRDdkQU4',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));


        if ($listGetEnMessage) {
            $i = 0;
            // Need to be splitted since FCM only allow maximum 1000 target tokens per request
            while($i < $listGetEnMessage->count()) {
                $fcmNotification['registration_ids'] = $listGetEnMessage->slice($i, 1000)->values()->all();
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                $result = curl_exec($ch);
                error_log("[Notification] daily:");
                error_log(json_encode($fcmNotification));
                error_log(json_encode($result));
                $i = $i + 1000;
            }
            curl_close($ch);
        }
        if ($listGetViMessage) {
            $fcmNotification['notification'] = $notification_vi;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $i = 0;
            // Need to be splitted since FCM only allow maximum 1000 target tokens per request
            while($i < $listGetViMessage->count()) {
                $fcmNotification['registration_ids'] = $listGetViMessage->slice($i, 1000)->values()->all();
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                $result = curl_exec($ch);
                error_log("[Notification] daily:");
                error_log(json_encode($fcmNotification));
                error_log(json_encode($result));
                $i = $i + 1000;
            }
            curl_close($ch);
        }

        return true;
    }

    /**
     * @return Notifications|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null
     */
    function get_notification_message()
    {
        $current_date = Carbon::parse(Carbon::now()->toDateString());
        $current_date_string = $current_date->toDateTimeString();
        $message_obj = Notifications::where('day_using', $current_date_string)->first();
        if (!$message_obj) {
            $dayOfWeek = Carbon::now()->dayOfWeek;
            $the_first_date_of_week = $current_date->subDays($dayOfWeek-1);
            $the_first_date_of_week_string = $the_first_date_of_week->toDateTimeString();
            $message_obj = Notifications::where('day_using','<', $the_first_date_of_week_string)->orWhere('day_using', null)->inRandomOrder()->first();
            if ($message_obj) {
                $message_obj->day_using = $current_date_string;
                $message_obj->count += 1;
                $message_obj->save();
            }
        }


        return $message_obj;
    }
}
