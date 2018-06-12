<?php
return [
    // user roles
    'roles' => [
        'super_admin' => 1,
        'admin' => 2,
        'mod' => 3,
        'member' => 4,
    ],

    // suggest status
    'suggest' => [
        'status' => [
            'suggested' => 1,
            'liked' => 2,
            'passed' => 3,
            'approved' => 4,
            'unmatch' => 5,
        ],
        'limit' => 3
    ],

    'jwt' => [
        'token_expire' => 30 * 24 *3600
    ],

    'error_type' => [
        'not_found' => 'NotFound',
        'bad_request' => 'BadRequest',
        'un_know' => 'UnKnow',
        'server_error' => 'ServerError',
        'oauth_exception' => 'OAuthException'
    ],

    'error_code' => [
        'common' => [
            'not_found' => 404, // not found
            'un_know' => 100, // un know
            'server_error' => 500 // server error
        ],

        'auth' => [
            'email_exists' => 701,
            'invalid_credentials' => 702,
            'login_email_failed' => 703,
            'login_facebook_failed' => 704,
            'facebook_token_wrong' => 705,
            'get_profile_error' => 706,
            'param_wrong' => 708,
            'get_friend_facebook_failed' => 709,
            'token_expired' => 401,
            'token_wrong' => 401,
        ]
    ],
];