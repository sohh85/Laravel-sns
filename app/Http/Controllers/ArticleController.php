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
    // （DI）ララベルのコントローラーはメソッドの引数で型宣言を行うと、そのクラスのインスタンスが自動生成されメソッド内で使える
    public function store(ArticleRequest $request, Article $article)
    {
        $article->title = $request->title;
        $article->body = $request->body;
        $article->user_id = $request->user()->id;
        $article->save();
        return redirect()->route('articles.index');
    }
}
