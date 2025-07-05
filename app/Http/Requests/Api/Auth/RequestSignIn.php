<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RequestSignIn extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_email' => 'required|email|exists:users,user_email',
            'password'   => 'required',
        ];
    }
}
