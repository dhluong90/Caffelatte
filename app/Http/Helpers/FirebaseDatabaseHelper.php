<?php

namespace App\Http\Helpers;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

Class FirebaseDatabaseHelper {

    /**
     * Get Firebase Connection
     * @param string
     * @return string
     */
    public static function get_firebase_connection() {
        $serviceAccount = FirebaseDatabaseHelper::get_service_account();
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://cafe-latte-198808.firebaseio.com/')
            ->create();
        return $firebase->getDatabase();
    }

    public static function get_service_account() {
        return ServiceAccount::fromJsonFile(__DIR__.Constants::FirebaseJsonFileName);
    }
}