<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        if (is_null($header)) {
            return response()->json(['result' => 'error'], 401);
        }
        $token = str_replace('Bearer ', '', $header);

        $session = DB::table('sessions')
            ->where('token', '=', $token)
            ->first();

        if (is_null($session)) {
            return response()->json(['result' => 'error'], 401);
        }

        return $next($request);
    }
}
