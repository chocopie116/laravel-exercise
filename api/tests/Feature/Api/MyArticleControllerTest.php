<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Session;
use Tests\TestCase;

class MyArticleControllerTest extends TestCase
{
    /**
     * @test
     */
    public function 自分の記事取得APIをたたくと記事一覧がかえる()
    {
        $session = factory(Session::class)->create();
        factory(Article::class)->create(['user_id' => $session->user_id]);

        $response = $this->withHeaders([
                'Authorization' => "Bearer $session->token"
            ])
            ->json('GET', "/api/users/me/articles");

        $response->assertStatus(200);

        //TODO userとhashtagがレスポンスに含まれてないので実装修正する
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
            ]
        ]);
    }

    /**
     * @test
     */
    public function 記事作成APIたたいてyesnoにYESといわれたら200が返る()
    {
        //yesno.wtfのAPIの結果に応じて200 or 400がでるのでテストがかけない
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function 記事更新APIたたいてyesnoにYESといわれない場合400が返る()
    {
        //yesno.wtfのAPIの結果に応じて200 or 400がでるのでテストがかけない
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function 自分の記事の更新APIたたくと200がかえる()
    {
        $session = factory(Session::class)->create();
        $article = factory(Article::class)->create(['user_id' => $session->user_id]);

        $response = $this->withHeaders([
                'Authorization' => "Bearer $session->token"
            ])
            ->json('PUT', "/api/articles/{$article->id}", [
                'title' => 'Updated title',
                'content' => 'Updated Content',
                'draft' => false,
                'hashtag_ids.*' => [],
            ]);

        $response->assertStatus(200);
        $response->assertExactJson(['result' => 'ok']);
    }
    /**
     * @test
     */
    public function 他人の更新APIたたくと200がかえる()
    {
        $session = factory(Session::class)->create();
        $otherArticle = factory(Article::class)->create();

        $response = $this->withHeaders([
                'Authorization' => "Bearer $session->token"
            ])
            ->json('PUT', "/api/articles/{$otherArticle->id}", [
                'title' => 'Updated title',
                'content' => 'Updated Content',
                'draft' => false,
                'hashtag_ids.*' => [],
            ]);

        $response->assertStatus(404);
    }
}
