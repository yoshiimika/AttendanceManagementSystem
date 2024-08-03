<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
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
    public function rules()
    {
        return [
            'email' => ['required','email','string','max:191'],
            'password' => ['required','min:8','max:191'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名＠ドメイン」形式で入力してください',
            'email.string' => 'メールアドレスは文字列で入力してください',
            'email.max:191' => 'メールアドレスは191文字以内で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min:8' => 'パスワードは8文字以上で入力してください',
            'password.max:191' => 'パスワードは191文字以下で入力してください',
        ];
    }
}