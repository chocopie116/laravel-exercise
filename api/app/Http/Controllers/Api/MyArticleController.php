<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
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

    public function update(Request $request, $articleId)
    {
        $params = $request->all();

        $validation = Validator::make($params, [
            'title' => 'required|string|max:20',
            'content' => 'required|string|max:30',
            'draft' => 'boolean',
            'hashtag_ids.*' => 'integer',
            'image_url' => 'string|url',
        ]);

        if ($validation->fails()) {
            return response()->json(['result' => 'error'], 400);
        }

        $title = $params['title'] ?? '';
        $content = $params['content'] ?? '';
        $draft = $params['draft'] ?? false;
        $hashtagIds = $params['hashtag_ids'] ?? [];
        $imgUrl = $params['image_url'] ?? '';
        $userId = $this->fetchUserId($request);

        $article = DB::table('articles')->find($articleId);
        if (is_null($article)) {
            return response()->json([], 404);
        }

        //自分以外のリソースの更新は不可能
        if ($article->user_id != $userId) {
            return response()->json([], 404);
        }

        DB::beginTransaction();
        try {
            $articleId = DB::table('articles')
            ->where('id', '=', $articleId)
            ->update([
                 'title' => $title,
                 'content' => $content,
                 'draft' => $draft,
                 'header_image_url' => $imgUrl,
                 'user_id' => $userId
            ]);

            DB::table('hashtag_articles')
            ->where('id', '=', $articleId)
            ->delete();

            foreach ($hashtagIds as $hashtagId) {
                DB::table('hashtag_articles')->insert([
                    'article_id' => $articleId,
                    'hashtag_id' => $hashtagId,
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json(['result' => 'ok']);
    }
}
