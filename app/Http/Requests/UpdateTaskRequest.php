<?php

namespace App\Http\Requests;

use App\Enums\Tasks\Priority;
use App\Enums\Tasks\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('tasks')->ignore($this->task->id),
            ],
            'description' => 'required|max:255',
            'state' => ['required', Rule::enum(State::class)],
            'priority' => ['required', Rule::enum(Priority::class)],
        ];
    }
}
