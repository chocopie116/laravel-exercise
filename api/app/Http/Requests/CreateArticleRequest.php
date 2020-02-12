<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    public function authorize()
    {
        //falseを返すと403エラーになる
        //認証はMiddlewareのlayerで解決するため常にtrueを返す
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
}
