<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleService
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create($params, $userId)
    {
        $response = $this->client->get('https://yesno.wtf/api');
        $json = $response->getBody()->getContents();
        $result = json_decode($json, true);

        if ($result['answer'] !== 'yes') {
            return false;
        }

        $title = $params['title'] ?? '';
        $content = $params['content'] ?? '';
        $draft = $params['draft'] ?? false;
        $hashtagIds = $params['hashtag_ids'] ?? [];
        $imgUrl = $params['image_url'] ?? '';

        DB::beginTransaction();
        try {
            $articleId = DB::table('articles')->insertGetId([
                'title' => $title,
                'content' => $content,
                'draft' => $draft,
                'header_image_url' => $imgUrl,
                'user_id' => $userId
            ]);

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

        return true;
    }

    public function update($params, $userId, $articleId)
    {
        $title = $params['title'] ?? '';
        $content = $params['content'] ?? '';
        $draft = $params['draft'] ?? false;
        $hashtagIds = $params['hashtag_ids'] ?? [];
        $imgUrl = $params['image_url'] ?? '';

        $article = DB::table('articles')->find($articleId);
        if (is_null($article)) {
            throw new NotFoundHttpException("article not found [articleId] $articleId");
        }

        //自分以外のリソースの更新は不可能
        if ($article->user_id != $userId) {
            throw new NotFoundHttpException("other Users article cannot edit");
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
