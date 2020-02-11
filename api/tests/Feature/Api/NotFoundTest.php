<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class NotFoundTest extends TestCase
{
    /**
     * @test
     */
    public function ルーティング定義ないエンドポイントは404()
    {
        $response = $this->json('GET', '/api/not-found');

        $response->assertStatus(404)
            ->assertExactJson([]);
    }
}
