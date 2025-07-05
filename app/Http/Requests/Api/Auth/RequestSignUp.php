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
            'user_email' => 'required|email|unique:users,user_email',
            'user_name'  => 'required|max:255|unique:users,user_name',
            'password'   => 'required',
            'confirmPassword' => 'required|same:password'
        ];
    }
}
