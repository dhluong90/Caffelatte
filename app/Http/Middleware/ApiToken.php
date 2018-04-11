<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\Business\UserModel;
use App\Http\Models\Dal\UserQModel;
use App\Http\Helpers\ApiHelper;
use \Firebase\JWT\JWT;
use \Illuminate\Http\Request;

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
                400
            );
        }

        // check token expired
        if (isset($jwt->exp) && $jwt->exp < time()) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.token_expired'),
                'token expired',
                400
            );
        }

        $user = UserQModel::get_user_by_token($token);
        if (!$user) {
            return ApiHelper::error(
                config('constant.error_type.bad_request'),
                config('constant.error_code.auth.token_wrong'),
                'token wrong',
                400
            );
        }

        $request->request->add(['user_id' => $user->id]);

        return $next($request);
    }
}