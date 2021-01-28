<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;


class ArticleController extends Controller
{

    // 各アクションのpolicyを参照しに行く
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

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

    // 記事削除機能
    public function destroy(Article $article) {

        $article->delete();
        return redirect()->route('articles.index');
    }

    // 記事閲覧
    public function show(Article $article) {

        return view('articles.show', ['article' => $article]);
    }

    // いいね機能
    public function like(Request $request, Article $article) {

        // 二重でいいね出来ないようにdetach(削除)->attach(登録)するようにしている
        // jsでの処理も行うが、サーバーサイドでも対策する
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    // いいね削除機能
    public function unlike(Request $request, Article $article) {

        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
