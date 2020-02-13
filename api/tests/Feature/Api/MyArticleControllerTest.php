<?php

namespace Tests\Feature\Api;

use App\Models\Article;
use App\Models\Session;
use GuzzleHttp\Client;
use Mockery;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
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
        $session = factory(Session::class)->create();

        /**
         * APIリクエストの結果をモックしている
         */
        $json = '{"answer":"yes","forced":false,"image":"https://example.com/dummy.png"}';
        $mockClient = Mockery::mock(Client::class);
        $mockResponse = Mockery::mock(ResponseInterface::class);
        $mockBody = Mockery::mock(MessageInterface::class);
        $mockBody->shouldReceive('getContents')
            ->andReturn($json);
        $mockResponse->shouldReceive('getBody')
            ->andReturn($mockBody);
        $mockClient->shouldReceive('get')
            ->with('https://yesno.wtf/api')
            ->andReturn($mockResponse);

        //コンテナに登録されたClientクラスをmockClientで上書き
        $this->instance(Client::class, $mockClient);

        $response = $this->withHeaders([
                'Authorization' => "Bearer $session->token"
            ])
            ->json('POST', "/api/articles/", [
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
    public function 記事更新APIたたいてyesnoにYESといわれない場合400が返る()
    {
        $session = factory(Session::class)->create();

        /**
         * APIリクエストの結果をモックしている
         */
        $json = '{"answer":"no"}';
        $mockClient = Mockery::mock(Client::class);
        $mockResponse = Mockery::mock(ResponseInterface::class);
        $mockBody = Mockery::mock(MessageInterface::class);
        $mockBody->shouldReceive('getContents')
            ->andReturn($json);
        $mockResponse->shouldReceive('getBody')
            ->andReturn($mockBody);
        $mockClient->shouldReceive('get')
            ->with('https://yesno.wtf/api')
            ->andReturn($mockResponse);

        //コンテナに登録されたClientクラスをmockClientで上書き
        $this->instance(Client::class, $mockClient);

        $response = $this->withHeaders([
                'Authorization' => "Bearer $session->token"
            ])
            ->json('POST', "/api/articles/", [
                'title' => 'Updated title',
                'content' => 'Updated Content',
                'draft' => false,
                'hashtag_ids.*' => [],
            ]);

        $response->assertStatus(400);
        $response->assertExactJson([
            'result'=> 'error',
            'message' => "yesno.wtf didn't answer yes",
        ]);
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
