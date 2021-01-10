<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    // 「get...Attribute」という形式になっているメソッドが「アクセサ」という
    // つまり、$tag->hashtagで呼びだせる
    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }
}
