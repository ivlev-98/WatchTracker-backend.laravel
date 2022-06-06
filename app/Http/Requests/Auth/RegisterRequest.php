<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:32'],
            'email' => ['required', 'email', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', Password::default()]
        ];
    }
}
