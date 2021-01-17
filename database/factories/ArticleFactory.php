<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\User;
use Faker\Generator as Faker;

// fakerを使って数字に合わせたランダムな文字列を生成
$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'body' => $faker->text(500),
        'user_id' => function () {
            return factory(User::class);
        }
    ];
});
