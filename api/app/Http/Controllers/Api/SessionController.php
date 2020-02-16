<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\DestroySessionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function create(CreateSessionRequest $request)
    {
        $params = $request->validated();

        $user = DB::table('users')
            ->where('email', '=', $params['email'])
            ->first();

        if (is_null($user)) {
            return response()->json(['result' => 'error'], 404);
        }

        if (!Hash::check($params['password'], $user->password)) {
            return response()->json(['result' => 'error'], 404);
        }

        $token = Str::random(50);
        DB::table('sessions')->insert([
             'user_id'  => $user->id,
             'token' => $token,
        ]);

        return response()->json(['token' => $token]);
    }

    public function destroy(DestroySessionRequest $request)
    {
        $p = $request->validated();

        $session = DB::table('sessions')
            ->where('token', '=', $p['token'])
            ->first();

        if (is_null($session)) {
            return response()->json(['result' => 'error'], 404);
        }

        $userId = $this->fetchUserId($request);
        if ($session->user_id !== $userId) {
            return response()->json(['result' => 'error'], 404);
        }

        DB::table('sessions')
            ->where('token', '=', $p['token'])
            ->delete();

        return response()->json([], 204);
    }
}
