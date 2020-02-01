<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function index()
    {
        $hashtags= DB::table('hashtags')->get();

        return response()->json($hashtags);
    }

    public function show($id)
    {
        $hashtags  = DB::table('hashtags')->find($id);

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

        DB::table('hashtags')->insert([
             'title' => $title,
        ]);

        return response()->json(['result' => 'ok']);
    }
}
