<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $status = true;
        if (!($request->hasHeader('Authorization'))) {
            $status = false;
        }
        if (!$request->bearerToken()) {
            $status = false;
        }
        if (!$status) {
            return response()->json(["status" => false, "message" => "Unauthorized user1"]);
        }
      
        $user = JWTAuth::parseToken()->authenticate();
       if(!$user){
        return response()->json(["status"=>false,"message"=>"Unauthorized user"]);
       }
       return $next($request);
       
    }
}
