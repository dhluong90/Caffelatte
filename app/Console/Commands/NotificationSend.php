<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\Dal\CustomerQModel;

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

    public function send_notification_everyday() {
        $customers = CustomerQModel::get_users_fcm_token();
        dd($customers);
    }
}
