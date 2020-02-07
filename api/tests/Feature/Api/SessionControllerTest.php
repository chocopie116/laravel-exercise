<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testセッションを作成できたら200がかえる()
    {
        $response = $this->json('POST', '/api/users', [
            'name'     => 'Labot Taro',
            'email'    => 'labot@example.com',
            'password' => 'password1234',
        ]);


        $response = $this->json('POST', '/api/sessions', [
            'email'    => 'labot@example.com',
            'password' => 'password1234',
        ]);

        $response->assertStatus(200);

        //TODO token文字列もvalidationできたらしたい
        $response->assertJsonStructure([
            'token'
        ]);
    }

    public function test存在するユーザーに存在しないパスワードを投げると404()
    {
        $p = [
            'name'     => 'Labot Taro',
            'email'    => 'labot@example.com',
            'password' => 'password1234',
        ];
        $response = $this->json('POST', '/api/users', $p);

        $response = $this->json('POST', '/api/sessions', [
            'email'    => 'labot@example.com',
            'password' => 'password9876',
        ]);

        $response->assertStatus(404);
    }
}
