<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHashtagRequest;
use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function index()
    {
        $hashtags= Hashtag::all();

        return response()->json($hashtags);
    }

    public function show($id)
    {
        $hashtags  = Hashtag::findOrFail($id);

        return response()->json($hashtags);
    }

    public function create(CreateHashtagRequest $request)
    {
        $params = $request->validated();

        $hashtag = new Hashtag();
        $hashtag->title = $params['title'];
        $hashtag->save();

        return response()->json([
            'result' => 'ok'
        ], 201);
    }
}
