<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers; // ログイン関係のいろんなメソッド定義されてる
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // gppgleログインボタンが押されたら
    public function redirectToProvider(string $provider)
    { //socialiteのdriverメソッドに外部サービス名を渡す → redirectメソッドでそのサービスにリダイレクト
        return Socialite::driver($provider)->redirect();
    }

    // google側でアカウントが選択されたら
    public function handleProviderCallback(Request $request, string $provider)
    {
        // Laravel\Socialite\Two\User（googleのユーザ情報）を取得し変数に代入
        $providerUser = Socialite::driver($provider)->stateless()->user();

        //whereメソッドはコレクションの（キー名, 値）と一致するものを取得
        // ->getEmail()でメールアドレス取得しUserモデルに存在するか確認
        // 「モデル名::使いたいクエリビルダ」で使う
        $user = User::where('email', $providerUser->getEmail())->first();

        // $userがnullじゃなかったら次に
        if ($user) {
            // 下記でユーザをログイン状態に。login()の第2引数をtrueにすることでログアウトするまで状態キープ
            $this->guard()->login(
                $user,
                true
            ); // $thisは自身のオブジェクト
            return $this->sendLoginResponse($request); //ログイン後の画面に遷移
        } // ここでreturnすることでこのあとの登録処理に移らない

        return redirect()->route('register.{provider}', [
            'provider' => $provider,
            'email' => $providerUser->getEmail(),
            'token' => $providerUser->token, //googleから発行されたトークン
        ]);
    }
}
