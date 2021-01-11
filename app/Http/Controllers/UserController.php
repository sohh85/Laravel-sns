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
}
