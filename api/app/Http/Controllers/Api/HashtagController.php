<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $hashtags  = Hashtag::find($id);

        return response()->json($hashtags);
    }

    public function create(Request $request)
    {
        $params = $request->all();
        $title = $params['title'] ?? '';

        $hasTitleError = $title === '' || mb_strlen($title) >= 20;
        if ($hasTitleError) {
            return response()->json(['result' => 'error'], 400);
        }

        $hashtag = new Hashtag();
        $hashtag->title = $title;
        $hashtag->save();

        return response()->json(['result' => 'ok']);
    }
}
