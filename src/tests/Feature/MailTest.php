<?php

namespace Tests\Feature;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_mail_is_sent()
    {
        // テストユーザーを作成
        $user = User::factory()->create();

        // ユーザーを認証
        $this->actingAs($user);

        // 認証された状態でリクエストを送信
        $response = $this->get('/posts');

        // ステータスコードが200であることを確認
        $response->assertStatus(200);

        // メール送信をモック
        Mail::fake();

        // メールをキューに追加
        Mail::to($user->email)->queue(new WelcomeMail($user));

        // メールがキューに追加されたことを確認
        Mail::assertQueued(WelcomeMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}