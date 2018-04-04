<?php

namespace App\Http\Models\Dal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\Constants;

class DeviceQModel extends Model
{
    /**
     * get device by name and user_id
     * @param $name
     * @param $user_id
     * @return object|boolean : all properties from `devices` table,
     * returns false if no device is founded
     */
    public static function get_device_by_name_and_user_id($name, $user_id) {
        $result = DB::table(Constants::DEVICES)
                ->where([
                    ['name', '=', $name],
                    ['user_id', '=', $user_id],
                ])
                ->get();

        if (empty($result[0])) {
            return FALSE;
        }

        return $result[0];
    } 
}
