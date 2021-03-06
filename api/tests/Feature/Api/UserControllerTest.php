<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testパラメータなしは400がかえる()
    {
        $response = $this->json('POST', '/api/users');

        $response->assertStatus(400);
    }

    public function testユーザーが作成できたら200がかえる()
    {
        $response = $this->json('POST', '/api/users', [
            'name'     => 'Labot Taro',
            'email'    => 'labot@example.com',
            'password' => 'password1234',
        ]);

        $response->assertStatus(200)
            ->assertJson(['result' => 'ok']);
    }

    public function testユーザーが作成済のメールアドレスで登録したら400がかえる()
    {
        $existsUser = factory(User::class)->create();
        $p = [
            'name'     => 'Labot Taro',
            'email'    => $existsUser->email,
            'password' => 'password1234',
        ];

        $response = $this->json('POST', '/api/users', $p);
        $response->assertStatus(400);
    }
}
