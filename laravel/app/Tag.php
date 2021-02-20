<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
