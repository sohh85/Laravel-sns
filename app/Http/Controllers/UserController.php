<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(string $name)
    {
        $user = User::where('name', $name)->first();

        return view('users.show', [
            'user' => $user,
        ]); //ユーザーモデルの入った変数$userをbladeに渡す
    }

    public function follow(Request $request, string $name)
    { // URIのname部分が引数$nameに渡る
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        // lilesメソッドと同様に、削除→登録
        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);
        // $request->user()で、リクエストを行なったユーザーのユーザーモデルが返る

        // どのユーザのフォローが成功したかを配列で返す
        return ['name' => $name];
    }

    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }
}
