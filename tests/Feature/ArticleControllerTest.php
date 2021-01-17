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

    // ログイン済みユーザに関するチェック
    // このようにテストは、AAA(Arrange-Act-Assert)の構成で作る場合が多い
    public function testAuthCreate()
    {
        // テストに必要なUserモデルを「準備」
        $user = factory(User::class)->create();

        // ログインして記事投稿画面にアクセスすることを「実行」
        $response = $this->actingAs($user)
            ->get(route('articles.create'));

        // レスポンスを「検証」
        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }
}
