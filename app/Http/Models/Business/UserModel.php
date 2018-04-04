<?php

namespace App\Http\Models\Business;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Constants;
use App\Http\Models\Dal\UserCModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Models\Dal\DeviceQModel;
use App\Http\Models\Dal\DeviceCModel;
use App\Http\Models\Dal\UserFollowQModel;
use App\Http\Models\Dal\UserFollowCModel;
use Illuminate\Support\Facades\Hash;

class UserModel extends Authenticatable
{
    /**
     * check user is manager by id
     * @param id
     * @return boolean
     */
    public static function check_manager($user_id) {
        $user = UserQModel::get_user_by_id($user_id);

        if ($user->role == Constants::ROLES['admin'] || $user->role == Constants::ROLES['super_admin']) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * check user is admin by id
     * @param id
     * @return boolean
     */
    public static function check_admin($id) {
        $user = UserQModel::get_user_by_id($id);

        if ($user->role == Constants::ROLES['admin']) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * check user is super admin by id
     * @param id
     * @return boolean
     */
    public static function check_super_admin($id) {
        $user = UserQModel::get_user_by_id($id);

        if ($user->role == Constants::ROLES['super_admin']) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * check user is admin by id
     * @param object user
     * @param $device
     * @param $type_device
     * @return FALSE or token
     */
    public static function get_token($user, $name_device = null, $type_device = null) {
        // config token
        $token = md5($user->email . $user->password . time()) . '-' . base64_encode(time());

        // update or create record device token
        $device = DeviceQModel::get_device_by_name_and_user_id($name_device, $user->id);

        if ($device) {
            // update token
            DeviceCModel::update_token($device->id, $token);
        } else {
            // create device
            DeviceCModel::insert_device([
                'name' => $name_device,
                'type' => $type_device,
                'user_id' => $user->id,
                'token' => $token,
            ]);
        }

        return $token;
    }

    /**
     * login by username password
     * @param $username
     * @param $password
     * @return FALSE or object user
     */
    public static function login($username, $password) {
        $user = UserQModel::get_user_by_username($username);

        if (!$user || !Hash::check($password, $user->password)) {
            return FALSE;
        }

        return $user;
    }
}
