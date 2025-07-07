<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RequestSignUp extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_email'      => 'required|email|unique:users,user_email|max:255',
            'user_full_name'  => 'required|max:255',
            'password'        => 'required',
            'confirmPassword' => 'required|same:password',
            'user_name'       => [
                'required',
                'max:255',
                'unique:users,user_name',
                'alpha_num',     // hanya huruf dan angka
                'regex:/^\S*$/u' // tidak boleh ada spasi
            ],
        ];
    }

    public function attributes() : array
    {
        return [
            'user_email'      => 'email address',
            'user_full_name'  => 'full name',
            'user_name'       => 'username',
            'password'        => 'password',
            'confirmPassword' => 'confirm password',
        ];
    }
}
