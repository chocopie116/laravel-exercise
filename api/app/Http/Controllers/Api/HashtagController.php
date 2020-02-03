<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHashtagRequest;
use Illuminate\Support\Facades\DB;

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

    public function create(CreateHashtagRequest $request)
    {
        $params = $request->validated();

        DB::table('hashtags')->insert([
             'title' => $params['title'],
        ]);

        return response()->json(['result' => 'ok']);
    }
}
