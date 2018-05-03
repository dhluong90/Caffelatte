<?php

namespace App\Http\Helpers;

use App\Http\Helpers\Constants;
use Config;

Class NotificationHelper {
    /*
        body
        {
            "to": "d0zkgaLhm18:APA91bErEF30uGmuUpefi3nYBZVuHfo_wqR-5GG_qMgPzPtoowlGY67vdfLn5ZNbFjBA-t5Z_JSClfnFcVHSUFSg8ArhiRWH8xagpJYpNoVL4Oolv1zxapwEVD36w1SSIiChsjSoZ3nV",
            "notification": {
                "body": "Hello",
                "title": "This is test message."
            },
            "data" : {
                 "key_1" : "Data for key_1",
                 "key_2" : "Data for key_2"
            }
        }

        response
        {
            "multicast_id": 6602502827485899322,
            "success": 1,
            "failure": 0,
            "canonical_ids": 0,
            "results": [
                {
                    "message_id": "0:1525247321541709%6e94ad276e94ad27"
                }
            ]
        }
    */

    /**
     * send
     * @param fcm_token
     * @param notification
     * @param data
     * @return respone
     */
    public static function send($fcm_token, $notification, $data) {
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('POST', 'https://fcm.googleapis.com/fcm/send', [
                    'headers' => [
                        'Authorization' => 'key=AAAA6l_om9s:APA91bE7S65RvR2p0GnL6MYpy4PtE4yWdPpDmBwL7KcVFtsMIvyvZf5jIkqhtrqQgfWKjTiu8VbUcDvtDeEFSLBI4SiInriwfGDxGDC2XzfYDljgjVc8chmItfDcExek-XTeVmKlNuRA',
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                        'to' => $fcm_token,
                        'notification' => $notification,
                        'data' => $data
                    ])
                ]);

            if ($res->getStatusCode() == 200) {
                $data = json_decode($res->getBody()->getContents());
                if ($data->success == 1) {
                    return true;
                }
            }
        } catch(\Exception $e) {
            return false;
        }

        return false;
    }
}