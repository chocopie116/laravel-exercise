<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testセッションを作成できたら200がかえる()
    {
        $user = factory(User::class)->create(['email' => 'labot@example.com']);

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
        $user = factory(User::class)->create(['email' => 'labot@example.com']);

        $response = $this->json('POST', '/api/sessions', [
            'email'    => 'labot@example.com',
            'password' => 'not-found-password',
        ]);

        $response->assertStatus(404);
    }
}
