<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull() // isLikedByにnullを渡したら正常にfalseが返るか
    {
        // ファクトリによって生成されたArticleモデルがデータベースに保存され、さらに$articleに代入
        $article = factory(Article::class)->create();

        // Articleクラスのインスタンスが代入された$articleがisLikedByメソッドを使用
        $result = $article->isLikedBy(null); // isLikedByメソッドを使用

        // assertFalseメソッドで引数がfalseかどうかをテスト
        $this->assertFalse($result);
    }

    public function testIsLikedByTheUser() // いいねシているユーザを渡したら正常にtrueが返るか
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        // Userモデルのlikesメソッドを呼び出し、
        $article->likes()->attach($user);

        // Articleクラスのインスタンスが代入された$articleで、isLikedByメソッドを使用
        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }
}
