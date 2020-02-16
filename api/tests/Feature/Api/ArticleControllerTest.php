<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\User;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    /**
     * @test
     */
    public function 記事一覧APIたたくと記事一覧がかえってくる()
    {
        factory(Article::class)->create();
        $response = $this->json('GET', '/api/articles');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'title',
                'content',
                'user_id',
                'draft',
                'header_image_url',
                'updated_at',
                'created_at',
                'id',
                'user',
                'hashtags'
            ]
        ]);
    }

    /**
     * @test
     */
    public function 記事詳細APIたたくと記事が1件かえってくる()
    {
        $article = factory(Article::class)->create();
        $response = $this->json('GET', sprintf('/api/articles/%s', $article->id));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'title',
            'content',
            'user_id',
            'draft',
            'header_image_url',
            'updated_at',
            'created_at',
            'id',
            'user',
            'hashtags'
        ]);
    }


    /**
     * @test
     */
    public function 存在しない記事IDで記事詳細APIをリクエストしたら404()
    {
        $response = $this->json('GET', '/api/articles/999999999');
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function ユーザーIDを指定して記事一覧APIをリクエストしたら記事一覧がかえってくる()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->json('GET', "/api/users/{$user->id}/articles");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'title',
                'content',
                'user_id',
                'draft',
                'header_image_url',
                'updated_at',
                'created_at',
                'id',
                'user',
                'hashtags'
            ]
        ]);
    }
}
