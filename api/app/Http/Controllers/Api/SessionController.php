<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function create(Request $request)
    {
        $params = $request->all();

        $validation = Validator::make($params, [
            'email' => 'required|string|max:20',
            'password' => 'required|string|min:10|max:50',
        ]);

        if ($validation->fails()) {
            return response()->json(['result' => 'error'], 400);
        }

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

    public function destroy(Request $request)
    {
        $p = $request->all();
        $validation = Validator::make($p, [
            'token' => 'required|string|max:50',
        ]);
        if ($validation->fails()) {
            return response()->json(['result' => 'error'], 400);
        }

        $userId = $this->fetchUserId($request);
        DB::table('sessions')
            ->where('token', '=', $p['token'])
            ->where('user_id', '=', $userId)
            ->delete();

        return response()->json([], 204);
    }
}
