<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testパラメータないとバリデーションエラー()
    {
        $response = $this->json('POST', '/api/users');

        $response->assertStatus(400);
    }
}
