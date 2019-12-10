<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Models\Dal\CustomerQModel;
use App\Http\Models\Dal\CustomerCModel;
use Log;

class ResetPointAndDirectMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:reset-point-and-remain-dm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset point and direct message every day';


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
        $this->send_reset_point_and_remain_dm_everyday();
    }

    public function send_reset_point_and_remain_dm_everyday()
    {
        $list_customer = CustomerQModel::get_all_user();

        $remain_like = config('constant.customer.remain_like');
        $remain_direct_message = config('constant.customer.remain_direct_message');

        foreach($list_customer as $member) {
            Log::debug("reset customer".$member->id."with: ".$remain_like." remain_dm: ".$remain_direct_message);
            CustomerCModel::update_user($member->id, [
                'point' => $remain_like,
                'remain_direct_message' => $remain_direct_message
            ]);
        }
    }

}
