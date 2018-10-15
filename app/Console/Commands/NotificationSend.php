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
        $list_customer = CustomerQModel::get_users_fcm_token_with_language_and_country('');
        $listGetEnMessage = $list_customer->pluck('fcm_token');
        $listGetViMessage = $list_customer_vi->pluck('fcm_token');

        $message = $this->get_notification_message();
        $notification = [
//            'title' => 'Tin nhắn hàng ngày',
            'body' => $message->content_en,
            'sound' => true
        ];

        $notification_vi = [
//            'title' => 'Tin nhắn hàng ngày',
            'body' => $message->content,
            'sound' => true
        ];

        $fcmNotification = [
            'registration_ids' => $listGetEnMessage, //multple token array
//            'to'        => $token, //single token
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
            $result = curl_exec($ch);
            curl_close($ch);
        }


        if ($listGetViMessage) {
            $fcmNotification['registration_ids'] = $listGetViMessage;
            $fcmNotification['notification'] = $notification_vi;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);
        }


//        $customer_fcm_tokens = array_column($customers, 'fcm_token');
//        foreach ($customers as $customer) {
//            dd($customer);
//        }

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
