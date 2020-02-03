<?php
namespace App\Http\Requests;

class CreateHashtagRequest extends ApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:20',
        ];
    }
}
