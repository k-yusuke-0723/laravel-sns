<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    // 一覧
    public function index()
    {
        $articles = Article::all()->sortByDesc('created_at');
        return view('articles.index', ['articles' => $articles]);
    }

    // 記事作成画面
    public function create() {
        return view('articles.create');
    }

    // 記事投稿機能
    // 第一引数がArticleRequestクラスのインスタンスであることを宣言
    public function store(ArticleRequest $request, Article $article) {


        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();
        return redirect()->route('articles.index');
    }

    // 記事編集画面
    public function edit(Article $article) {

        return view('articles.edit', ['article' => $article]);

    }

    // 記事編集機能
    public function update(ArticleRequest $request, Article $article) {

        $article->fill($request->all())->save();
        return redirect()->route('articles.index');
    }

}
