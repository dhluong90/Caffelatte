<?php

namespace App\Http\Helpers;

Class ResponseHelper {
    /*
        {
            "meta": {
                 "error_type": "OAuthException",
                 "code": 400,
                 "error_message": "..."
            },
            "data": {
                 ...
                "pagination": {
                     "next_url": "...",
                     "next_max_id": "13872296"
                }
            },
        }
    */

    // error type
    const NOT_FOUND = 'NotFound';
    const UNKNOWN = 'UnKnow';
    const SERVER_ERROR = 'ServerError';

    // error type user
    const USERNAME_PASSWORD_REQUIRE = 'UsernamePasswordRequire';
    const USERNAME_PASSWORD_INCORRECT = 'UsernamePasswordIncorrect';

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
     * @param string $error_type
     * @param array $error_message
     * @param int $status_code
     * @return json object
     */
    public static function error($error_type = self::UNKNOWN, $error_message = [], $status_code = 500) {
        return response(json_encode([
            'meta' => (object) [
                "error_type" => $error_type,
                "error_message" => $error_message,
            ],
        ]), $status_code)->header('Content-Type', 'application/json');
    }
}