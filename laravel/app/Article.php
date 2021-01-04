<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
