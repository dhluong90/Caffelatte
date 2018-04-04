<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class DeviceCModel extends Model
{
    /**
     * insert device
     * @param array data
     * @return boolean
     */
    public static function insert_device($data) {
        return DB::table(Constants::DEVICES)->insert($data);
    }

    /**
     * update token device by device_id
     * @param device_id
     * @param token
     * @return boolean
     */
    public static function update_token($device_id, $token) {
        return DB::table(Constants::DEVICES)
                ->where('id', $device_id)
                ->update(['token' => $token]);
    }
}