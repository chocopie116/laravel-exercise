<?php
namespace App\Http\Requests;

class CreateArticleRequest extends ApiRequest
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
}
