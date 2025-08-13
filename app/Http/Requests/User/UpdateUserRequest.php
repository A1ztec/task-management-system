<?php

namespace App\Http\Requests\user;

use App\Enums\User\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['optional', 'string', 'max:255'],
            'email' => ['optional', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['optional', 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'role' => ['optional', 'string', Rule::enum(UserRole::class)],
        ];
    }
}
