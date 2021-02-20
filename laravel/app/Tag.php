<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    // 複数代入を許可
    protected $fillable = [
        'name',
    ];

    // ハッシュタグ表示用のアクセサ
    public function getHashtagAttribute(): string {

        return '#' . $this->name;
    }

    // 記事モデルへのリレーションを追加(多対多)
    public function articles(): BelongsToMany {

        return $this->belongsToMany('App\Article')->withTimestamps();
    }
}
