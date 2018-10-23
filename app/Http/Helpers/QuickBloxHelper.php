<?php

namespace App\Http\Helpers;

use GuzzleHttp\Client;

Class QuickBloxHelper
{

    protected $url = 'https://api.quickblox.com/';
    protected $appId = '';
    protected $authenticateKey = '';
    protected $authenticateSecret = '';
    protected $username = '';
    protected $pass = '';
    protected $signature = '';
    protected $nonce = '';
    protected $timestamp = '';

    protected $headerRequest = [
        'Content-Type' => 'application/json',
        'QB-Account-Key' => ''
    ];

    public function __construct()
    {
        $this->appId = env('QUICKBLOX_APP_ID');
        $this->authenticateKey = env('QUICKBLOX_KEY');
        $this->authenticateSecret = env('QUICKBLOX_SECRET');
        $this->username = env('QUICKBLOX_USER');
        $this->pass = env('QUICKBLOX_PASS');
        $this->nonce = rand(1, 1000);
        $this->timestamp = time();
        $this->headerRequest['QB-Account-Key'] = $this->authenticateKey;
        $signature_string = "application_id=" . $this->appId . "&auth_key=" .
            $this->authenticateKey . "&nonce=" . $this->nonce . "&timestamp=" . $this->timestamp;
        $this->signature = hash_hmac('sha1', $signature_string, $this->authenticateSecret);

    }

    public function getToken()
    {
        $path = 'session.json';
        $post_body = http_build_query(array(
            'application_id' => $this->appId,
            'auth_key' => $this->authenticateKey,
            'timestamp' => $this->timestamp,
            'nonce' => $this->nonce,
            'signature' => $this->signature
        ));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url . $path); // Full path is - https://api.quickblox.com/session.json
        curl_setopt($curl, CURLOPT_POST, true); // Use POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POSTREDIR, true);
        $response = curl_exec($curl);
        curl_close($curl);
        // Check errors
        if ($response) {
            $res = json_decode($response);
            $token = $res->session->token;
            return $token;
        } else {
            $error = curl_error($curl) . '(' . curl_errno($curl) . ')';
            echo $error . "\n";
        }
        // Close connection


    }

    public function createNewUser($email, $login, $name)
    {
        $path = 'users.json';
        $token = $this->getToken();
        $user['login'] = $login;
        $user['password'] = md5($login);
        $user['email'] = $email;
        $user['facebook_id'] = $login;
        $user['full_name'] = $name;
        $requestBody['user'] = $user;
        $this->headerRequest['QB-Token'] = $token;
        $client = new Client([
            'headers' => $this->headerRequest,
            'http_errors' => false
        ]);
        $responseData = $client->post($this->url . $path,
            ['body' => json_encode(
                $requestBody
            )]);
        $codeResponse = $responseData->getStatusCode();

        if ($codeResponse == 422) {
            $path = 'users/by_facebook_id.json?facebook_id=' . $login;
            $client = new Client([
                'headers' => $this->headerRequest,
                'http_errors' => false
            ]);
            $responseData = $client->get($this->url . $path);
        }
        $result = $responseData->getBody();
        $result = json_decode($result);

        $chatId = $result->user->id;
        return $chatId;
    }

}