<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RequestPosting extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'image'   => 'required|image|mimes:jpg,jpeg,png|max:5096',
            'caption' => 'sometimes|nullable',
        ];
    }

    public function attributes() : Array
    {
        return [
            'image'    => 'Gambar',
            'caption'  => 'Caption'
        ];
    }
}
