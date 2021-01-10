<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
