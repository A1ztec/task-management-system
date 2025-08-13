<?php

namespace App\Http\Requests\User;

use App\Enums\User\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;

class UserRequest extends FormRequest
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
            'name' => [Rule::requiredIf($this->isMethod('post')), 'string', 'max:255'],
            'email' => [Rule::requiredIf($this->isMethod('post')), 'string', 'email', 'max:255', 'unique:users'],
            'password' => [Rule::requiredIf($this->isMethod('post')), 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'role' => [Rule::requiredIf($this->isMethod('post')), 'string', Rule::enum(UserRole::class)],
        ];
    }
}
