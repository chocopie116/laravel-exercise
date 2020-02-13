<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;

class ArticleService
{
    public function create($params, $userId, Client $client, Connection $con)
    {
        $response = $client->get('https://yesno.wtf/api');
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

        $con->beginTransaction();
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
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return true;
    }
}
