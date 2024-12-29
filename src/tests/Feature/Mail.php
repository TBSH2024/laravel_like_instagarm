<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class Mail extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testSendMail(): void
    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // ユーザーを認証
        $this->actingAs($user);

        // 認証された状態でリクエストを送信
        $response = $this->get('/');

        // ステータスコードが200であることを確認
        $response->assertStatus(200);

        Mail::to($user->email)->queue(new WelcomeMail($user));

        Mail::assertQueued(WelcomeMail::class);
    }
}
