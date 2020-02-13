<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Services\ArticleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MyArticleController extends Controller
{
    private $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    public function mine(Request $request)
    {
        $userId = $this->fetchUserId($request);

        $articles  = DB::table('articles')
            ->where('user_id', '=', $userId)
            ->get();

        return response()->json($articles);
    }

    public function create(CreateArticleRequest $request)
    {
        $params = $request->validated();
        $userId = $this->fetchUserId($request);

        $result = $this->service->create($params, $userId);
        if ($result === false) {
            return response()->json([
                'result' => 'error',
                'message' => "yesno.wtf didn't answer yes",
            ], 400);
        }

        return response()->json(['result' => 'ok']);
    }

    public function update(UpdateArticleRequest $request, $articleId)
    {
        $params = $request->validated();
        $userId = $this->fetchUserId($request);

        $this->service->update($params, $userId, $articleId);

        return response()->json(['result' => 'ok']);
    }
}
