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

    // 引数として渡されたユーザモデルがその記事をいいねしていれば「true」（型キャストでboolに変換）
    public function isLikedBy(?User $user): bool // ?を付けると、その引数がnullであることも許容
    {
        return $user // その記事をいいねしたユーザ(likesメソッド)の中に$userがいるかチェック
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false; // コレクションにはwhere(キー名, 値)がある
    }

    public function getCountLikesAttribute(): int  // いいねの数を計算するメソッド
    { // $this->likesにより、記事モデルからlikesテーブル経由で紐付いているユーザーが、コレクションで帰る
        return $this->likes->count();
    }

    public function tags(): BelongsToMany
    { // belongsToManyの第２引数には中間テーブル名が必要だがテーブルの単数形を繋げた名前なので省略できる
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
