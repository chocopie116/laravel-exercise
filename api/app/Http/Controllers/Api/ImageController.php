<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function create(Request $request)
    {
        $params = $request->all();
        $validation = Validator::make($params, [
            'file' => 'required|file|image|mimes:jpeg,png|max:3000',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 400);
        }

        $fileName = $request->file('file')->store('public/uploaded');
        $basePath = 'http://localhost:8000/storage/uploaded/%s';
        $path = sprintf($basePath, basename($fileName));

        return response()->json(['img' => $path], 201);
    }
}
