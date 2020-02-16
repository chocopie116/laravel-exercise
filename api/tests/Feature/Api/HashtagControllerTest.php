<?php

namespace Tests\Feature\Api;

use App\Models\Hashtag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HashtagControllerTest extends TestCase
{
    use RefreshDatabase;
    private $hashtag;

    //TestCase::setUpと型をあわせる必要があり:voidとかいてる
    public function setUp():void
    {
        parent::setUp();
        $this->hashtag = factory(Hashtag::class)->create();
    }

    /**
     * @test
     */
    public function ハッシュタグ一覧APIたたくと一覧がかえってくる()
    {
        $response = $this->json('GET', '/api/hashtags');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'title',
                'updated_at',
                'created_at',
                'id',
            ]
        ]);
    }

    /**
     * @test
     */
    public function ハッシュタグ詳細APIたたくと記事が1件かえってくる()
    {
        $response = $this->json('GET', sprintf('/api/hashtags/%s', $this->hashtag->id));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'title',
            'updated_at',
            'created_at',
            'id',
        ]);
    }

    /**
     * @test
     */
    public function 存在しない記事IDで記事詳細APIをリクエストしたら404()
    {
        $response = $this->json('GET', '/api/hashtags/999999999');
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function ハッシュタグ作成時にtitleがないと400()
    {
        $response = $this->json('POST', "/api/hashtags/", [
            ]);

        $response->assertStatus(400);
    }
    /**
     * @test
     */
    public function ハッシュタグは作成できる()
    {
        $response = $this->json('POST', "/api/hashtags/", [
                'title' => 'ハッシュタグ',
            ]);

        $response->assertStatus(201);
        $response->assertExactJson([
            'result'=> 'ok',
        ]);
    }
}
