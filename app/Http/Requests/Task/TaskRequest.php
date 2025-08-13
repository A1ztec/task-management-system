<?php

namespace App\Http\Requests\Task;

use App\Enums\task\TaskPriority;
use App\Enums\Task\TaskStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'title' => [Rule::requiredIf(fn() => $this->isMethod('POST')),  'string', 'max:255'],
            'description' => [Rule::requiredIf(fn() => $this->isMethod('POST')), 'string', 'max:2000'],
            'status' => [Rule::requiredIf(fn() => $this->isMethod('POST')), 'string', Rule::Enum(TaskStatus::class)],
            'priority' => [Rule::requiredIf(fn() => $this->isMethod('POST')), 'string', Rule::Enum(TaskPriority::class)],
            'due_date' => [Rule::requiredIf(fn() => $this->isMethod('POST')), 'date'],
            'user_id' => [Rule::requiredIf(fn() => $this->isMethod('POST')), 'integer', 'exists:users,id'],
        ];
    }
}
