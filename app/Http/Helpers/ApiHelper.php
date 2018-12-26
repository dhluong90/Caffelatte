<?php

namespace App\Http\Helpers;

use App\Http\Helpers\Constants;
use Config;

Class ApiHelper {
    /*
        error

        {
          "errors": {
            "type": "OAuthException",
            "code": 400,
            "message": "..."
          }
        }

       return 1 object

        {
          "data": {
              "id": 1,
              "name":"abc"
          }
        }

        return 1 array object

        {
          "data": {
            "items": [
              {
                "id": 1,
                "name": "abc"
              }
            ],
            "pagination": {
              "total_items": 123,
              "total_page": 7,
              "limit_item": 20
            }
          }
        }
    */

    /**
     * convert response success for api
     * @param object $data
     * @param int $status_code
     * @return json object
     */
    public static function success($data = null, $status_code = 200) {
        return response(json_encode([
            'data' => $data,
        ]), $status_code)->header('Content-Type', 'application/json');
    }

    /**
     * convert response error for api
     * @param string $type
     * @param string $code
     * @param array $error_message
     * @param int $status_code
     * @return json object
     */
    public static function error($type = 'UnKnow', $code = 500, $message = 'have an error', $status_code = 500) {
        return response(json_encode([
            'errors' => (object) [
                "type" => $type,
                "code" => $code,
                "message" => $message,
            ],
        ]), $status_code)->header('Content-Type', 'application/json');
    }

    public static function clear_data_member($data = []) {
        foreach ($data as $key => $value) {
            unset($value->password, $value->token, $value->fcm_token, $value->facebook_token);
        }

        return $data;
    }
}