<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateImageRequest;

class ImageController extends Controller
{
    public function create(CreateImageRequest $request)
    {
        $fileName = $request->file('file')->store('public/uploaded');

        //TODO hostを環境変数から取得するように変更する
        $basePath = 'http://localhost:8000/storage/uploaded/%s';
        $path = sprintf($basePath, basename($fileName));

        return response()->json(['img' => $path], 201);
    }
}
