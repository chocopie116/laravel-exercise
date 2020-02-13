<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Services\ArticleService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyArticleController extends Controller
{
    public function mine(Request $request)
    {
        $userId = $this->fetchUserId($request);

        $articles  = DB::table('articles')
            ->where('user_id', '=', $userId)
            ->get();

        return response()->json($articles);
    }

    public function create(CreateArticleRequest $request, ArticleService $service)
    {
        $params = $request->validated();
        $userId = $this->fetchUserId($request);

        $result = $service->create($params, $userId);
        if ($result === false) {
            return response()->json([
                'result' => 'error',
                'message' => "yesno.wtf didn't answer yes",
            ], 400);
        }

        return response()->json(['result' => 'ok']);
    }

    public function update(UpdateArticleRequest $request, $articleId, ArticleService $service)
    {
        $params = $request->validated();
        $userId = $this->fetchUserId($request);

        $service->update($params, $userId, $articleId);

        return response()->json(['result' => 'ok']);
    }
}
