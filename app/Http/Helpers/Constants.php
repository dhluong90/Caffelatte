<?php

namespace App\Http\Helpers;

Class Constants {
    // table
    const USERS = 'users';

    // user role
    const ROLES = [
        'super_admin' => 1,
        'admin' => 2,
        'mod' => 3,
        'member' => 4,
    ];

    const ERROR_TYPE = [
        'not_found' => 'NotFound',
        'un_know' => 'UnKnow',
        'server_rrror' => 'ServerError',
        'oauth_exception' => 'OAuthException'
    ];

    const ERROR_CODE = [
        'common' => [
            'not_found' => 1, // not found
            'un_know' => 2 // un know
        ],
        'auth' => [
            'facebook_error' => 1 // error server facebook
        ]
    ];

    // url image
    const MANAGE_IMAGE = [
        'user' => [
            'size' => ['150x150', '300x300'],
            'url' => 'uploads/user',
        ],
    ];

    const FirebaseJsonFileName = '/cafe-latte-198808-firebase-adminsdk-l67b1-d8841a097d.json';
}