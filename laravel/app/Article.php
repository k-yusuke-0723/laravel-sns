<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Article extends Model
{
    // クライアントが更新可能なカラム名(ホワイトリスト)
    protected $fillable = [
        'title',
        'body',
    ];

    public function user(): BelongsTo {
        // BelongsToメソッドの引数には関係するモデルの名前を文字列で渡す
        return $this->belongsTo('App\User');
    }

    public function likes(): BelongsToMany {

        // 第一引数に関係するモデル名を渡す
        // 第二引数には中間テーブルのテーブル名を渡す
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    // いいね済みか判定
    public function isLikedBy(?User $user): bool {

        return $user ? (bool)$this->likes->where('id', $user->id)->count() : false;
    }

    // いいね数カウント
    public function getCountLikesAttribute(): int {

        return $this->likes->count();
    }

    // tag
    public function tags(): BelongsToMany {

        // 第一引数に関係するモデル名
        // 中間テーブルの名前が「article_tag」という2つのモデル名の単数系なので省略可能
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
