<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    // 記事一覧表示で正しいステータスが返っているかチェック
    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
            ->assertViewIs('articles.index');
    }

    // 未ログイン状態のユーザに対するテスト
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        // assertRedirectメソッドでは引数に渡したURLにリダイレクトされたかテスト
        $response->assertRedirect(route('login'));
    }
}
