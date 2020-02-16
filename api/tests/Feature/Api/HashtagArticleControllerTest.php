<?php

namespace Tests\Feature\Api;

use App\Models\HashtagArticle;
use Tests\TestCase;

class HashtagArticleControllerTest extends TestCase
{
    /**
     * @test
     */
    public function 記事取得APIをたたくと記事一覧がかえる()
    {
        $hashtagArticle = factory(HashtagArticle::class)->create();

        $response = $this->json('GET', "/api/hashtags/{$hashtagArticle->hashtag_id}/articles");

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
