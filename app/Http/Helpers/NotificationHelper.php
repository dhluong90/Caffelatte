<?php

namespace App\Http\Helpers;

use App\Http\Helpers\Constants;
use Config;

Class NotificationHelper {

    /**
     * send
     * @param fcm_token
     * @param notification
     * @param data
     * @return respone
     */
    public static function send($fcm_token, $notification = null, $data = null) {

        $fcmBody = ['to' => $fcm_token];

        if ($notification) {
            // add sound default
            $notification['sound'] = 'default';
            $fcmBody['notification'] = $notification;
        }

        if ($data) {
            $fcmBody['data'] = (object) $data;
        }

        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('POST', 'https://fcm.googleapis.com/fcm/send', [
                    'headers' => [
                        'Authorization' => 'key=AAAA6l_om9s:APA91bE7S65RvR2p0GnL6MYpy4PtE4yWdPpDmBwL7KcVFtsMIvyvZf5jIkqhtrqQgfWKjTiu8VbUcDvtDeEFSLBI4SiInriwfGDxGDC2XzfYDljgjVc8chmItfDcExek-XTeVmKlNuRA',
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode($fcmBody)
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