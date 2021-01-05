<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // Articleモデルの全データが(sortByDescメソッドで)最新の投稿日時順に並び替えられた上で$articles に代入
        $articles = Article::all()->sortByDesc('created_at');

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        return view('articles.create');
    }

    // 第一引数$requestはA(ArticleRequestクラスのインスタンス)と指定
    // 指定することで、A以外のものが来たらTypeErrorという例外を発生させれる
    // int とか string とかも指定できる 
    // （DI）コントローラーはメソッドの引数で型宣言を行うと、そのクラスのインスタンスが自動生成されメソッド内で使える
    public function store(ArticleRequest $request, Article $article)
    {
        // Articleモデルのインスタンスである$articleのtitle、bodyプロパティに対し、
        // 記事登録画面から送信されたPOSTリクエストのtitleと本文bodyの値をそれぞれ代入
        // allメソッドで送信された値を配列で取得
        $article->fill($request->all());
        // リクエストのuserメソッドを使うとUserクラスのインスタンスにアクセスできる。
        // そこからユーザーのidを取得し、user_idプロパティに代入
        $article->user_id = $request->user()->id;
        // saveメソッドでarticlesテーブルにレコードを新規登録
        $article->save();
        return redirect()->route('articles.index');
    }

    // editアクションメソッド内の$articleにはArticleモデルのインスタンスが代入される
    public function edit(Article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    // 記事更新時の処理
    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();
        return redirect()->route('articles.index');
    }

    // 記事削除時の処理
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
