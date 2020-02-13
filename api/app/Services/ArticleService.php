<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

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
}
