<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    // バリデーションのルールを定義
    public function rules()
    {
        return [
            // 連想配列形式で、キーにパラメーターを、値にバリデーションルールを指定
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    //バリデーションエラーメッセージに表示される項目名をカスタマイズ
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
            'tags' => 'タグ',
        ];
    }

    //フォームリクエストのバリデーションが成功した後に自動的に呼ばれるメソッド
    public function passedValidation()
    { //便利な関数使うために、collectでコレクションに変換
        $this->tags = collect(json_decode($this->tags)) //json_decode関数でjsonデータを連想配列に変換
            ->slice(0, 5) //要素が0~5以外の場合カット
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
