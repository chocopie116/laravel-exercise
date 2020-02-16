<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:20',
            'email' => 'required|string|max:30|unique:users',
            'password' => 'required|string|min:10|max:50',
        ];
    }
}
