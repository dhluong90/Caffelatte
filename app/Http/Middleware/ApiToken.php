<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Dal\CustomerQModel;
use App\Http\Helpers\ApiHelper;
use \Firebase\JWT\JWT;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization');
        try {
            $jwt = JWT::decode($token, env('JWT_KEY'), ['HS256']);
        } catch (\Exception $e) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.token_wrong'),
                'token wrong',
                401
            );
        }

        // check token expired
        if (isset($jwt->exp) && $jwt->exp < time()) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.token_expired'),
                'token expired',
                401
            );
        }

        $user = CustomerQModel::get_user_by_token($token);
        if (!$user) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.token_wrong'),
                'token wrong',
                401
            );
        }

        $request->request->add(['user_id' => $user->id]);

        return $next($request);
    }

    public function terminate($request, $response)
    {
        Log::info('app.requests', [
            'device' => $request->header('User-Agent'),
            'url' => $request->url(),
            'token' => $request->header('Authorization'),
            'request' => $request->all(),
            'response' => $response
        ]);
    }
}