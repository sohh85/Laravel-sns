<?php

namespace App;

use App\Mail\BareMail;
use App\Notifications\PasswordResetNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token, new BareMail()));
    }

    // ユーザーモデルとユーザーモデルの関係は多対多なので、belongsToManyメソッド使用
    public function followers(): BelongsToMany
    { // 「テーブル名の単数形_id」に当てはまらないので、第三第四引数必要
        // belongsToMany('関係するモデル', '中間テーブル名', '中間テーブル内で対応しているID名', '関係するモデルで対応しているID名')。このメソッドを
        return $this->belongsToMany('App\User', 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }

    // followersメソッドとは3,4引数が逆。
    // ユーザーモデルにfollowingsメソッドを作成したことで、UserControllerのfollow/unfollowアクションメソッドは完成となります。
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }

    public function isFollowedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->followers->where('id', $user->id)->count()
            : false;
    }

    // followersメソッドで帰ってきたコレクションの数を、->count()で数える。
    // $user->count_followers としてbladeで使用
    public function getCountFollowersAttribute(): int
    {
        return $this->followers->count();
    }
    public function getCountFollowingsAttribute(): int
    {
        return $this->followings->count();
    }
}
