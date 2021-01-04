<?php

namespace App\Http\Controllers;

use App\Article;

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
}
