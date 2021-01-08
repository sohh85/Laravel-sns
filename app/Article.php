<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Article extends Model
{
    protected $fillable = [
        'title',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function likes(): BelongsToMany //いいねの記事モデルとユーザーモデルの関係は「多対多」
    { // belongsToMany(関係するモデル, 中間テーブル)
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    } //第二引数を省略すると、中間テーブル名は2つのモデル名の単数形をアルファベット順に結合した名前として処理
}
