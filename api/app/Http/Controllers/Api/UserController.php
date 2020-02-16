<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Mail\CompleteRegistrationMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $params = $request->validated();

        $user = new User();
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->password = Hash::make($params['name']);
        $user->save();

        Mail::to($params['email'])->send(new CompleteRegistrationMail($params['name']));

        return response()->json(['result' => 'ok']);
    }
}
