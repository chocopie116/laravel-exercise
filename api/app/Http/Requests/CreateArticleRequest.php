<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateArticleRequest extends FormRequest
{
    public function authorize()
    {
        //falseを返すと403エラーになる
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:20',
            'content' => 'required|string|max:30',
            'draft' => 'boolean',
            'hashtagIds.*' => 'integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'result' => 'error',
        ], 400));
    }
}
