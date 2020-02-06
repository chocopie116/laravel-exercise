<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use LogicException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function fetchUserId(Request $request)
    {
        $header = $request->header('Authorization');
        if (is_null($header)) {
            throw new LogicException('fetchUserId must be called after applying CheckLoginMiddleware');
        }
        $token = str_replace('Bearer ', '', $header);

        $session = DB::table('sessions')
            ->where('token', '=', $token)
            ->first();

        if (is_null($session)) {
            throw new LogicException('fetchUserId must be called after applying CheckLoginMiddleware');
        }

        return $session->user_id;
    }
}
