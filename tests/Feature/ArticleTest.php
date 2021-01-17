<?php

namespace Tests\Feature;

use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull()
    {
        // ファクトリによって生成されたArticleモデルがデータベースに保存され、さらに$articleに代入
        $article = factory(Article::class)->create();

        $result = $article->isLikedBy(null); // isLikedByメソッドを使用

        $this->assertFalse($result);
    }
}
