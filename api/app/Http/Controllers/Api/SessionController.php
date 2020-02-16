<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\DestroySessionRequest;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function create(CreateSessionRequest $request)
    {
        $params = $request->validated();

        $user = User::where('email', '=', $params['email'])
            ->first();

        if (is_null($user)) {
            return response()->json(['result' => 'error'], 404);
        }

        if (!Hash::check($params['password'], $user->password)) {
            return response()->json(['result' => 'error'], 404);
        }

        $session = new Session();
        $session->user_id = $user->id;
        $session->token = Str::random(50);

        return response()->json(['token' => $session->token]);
    }

    public function destroy(DestroySessionRequest $request)
    {
        $p = $request->validated();

        $session = Session::where('token', '=', $p['token'])
            ->first();

        if (is_null($session)) {
            return response()->json(['result' => 'error'], 404);
        }

        $userId = $this->fetchUserId($request);
        if ($session->user_id !== $userId) {
            return response()->json(['result' => 'error'], 404);
        }

        $session->delete();

        return response()->json([], 204);
    }
}
