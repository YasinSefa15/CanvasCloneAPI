<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user_token = DB::table('user_tokens')->where('token','=',$request->header('x-token'))->first();
        if(isset($user_token)){
            $user = DB::table('users')->where('id', '=' , $user_token->user_id)->first();
            $request->attributes->add([
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'token' => $user_token,
                    'account_type' => $user->account_type
                ]
            ]);

            return $next($request);
        }
        return response()->json([
            "code" => Response::HTTP_UNAUTHORIZED,
            "message" => "Geçersiz token",
        ],Response::HTTP_UNAUTHORIZED);
    }
}
