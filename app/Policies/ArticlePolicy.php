<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any articles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    // 他ユーザーが書いた記事を一覧画面や詳細画面で見て良いので一律true
    public function viewAny(?User $user) // ?を付けると、その引数がnullであることも許容
    {
        return true;
    }

    /**
     * Determine whether the user can view the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    // 他ユーザーが書いた記事を一覧画面や詳細画面で見て良いので一律true
    public function view(?User $user, Article $article) // ?を付けると、その引数がnullであることも許容
    {
        return true;
    }

    /**
     * Determine whether the user can create articles.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    // コントローラーのcreate/storeアクションメソッドに対応
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    // コントローラのedit/updateアクションメソッドに対応
    public function update(User $user, Article $article)
    {
        // ログイン中のユーザーのIDと記事モデルのユーザーIDが一致すればtrue
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    // コントローラのdeleteアクションメソッドに対応
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can restore the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function restore(User $user, Article $article)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the article.
     *
     * @param  \App\User  $user
     * @param  \App\Article  $article
     * @return mixed
     */
    public function forceDelete(User $user, Article $article)
    {
        //
    }
}
