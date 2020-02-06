<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $params = $request->all();

        $validation = Validator::make($params, [
            'name' => 'required|string|max:20',
            'email' => 'required|string|max:30',
            'password' => 'required|string|min:10|max:50',
        ]);

        if ($validation->fails()) {
            return response()->json(['result' => 'error'], 400);
        }

        DB::table('users')->insert([
             'name'     => $params['name'],
             'email'    => $params['email'],
             'password' => Hash::make($params['password']),
        ]);

        return response()->json(['result' => 'ok']);
    }
}
