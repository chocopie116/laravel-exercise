<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllertest extends testcase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function 記事一覧APIたたくと記事一覧がかえってくる()
    {
        factory(Article::class)->create();
        $response = $this->json('GET', '/api/articles');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
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
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
    }

    /**
     * @test
     */
    public function 記事一覧APIでページパラメータを指定したら２ページ目のページネーションができてるはず()
    {
        factory(Article::class, 11)->create();
        $response = $this->json('GET', '/api/articles?page=2');

        $response->assertStatus(200);

        //TODO テストデータによっては3になるかもしれないので要調整
        $response->assertJson(['current_page' =>2]);

        $response->assertJsonStructure([
            'current_page',
            'data' => [
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
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
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
