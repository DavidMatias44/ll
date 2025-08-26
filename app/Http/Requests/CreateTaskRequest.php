<?php

namespace App\Http\Requests;

use App\Enums\Tasks\Priority;
use App\Enums\Tasks\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:tasks',
            'description' => 'required|max:255',
            'due_date' => 'date_format:Y-m-d|after_or_equal:today',
            'state' => ['required', Rule::enum(State::class)],
            'priority' => ['required', Rule::enum(Priority::class)],
        ];
    }
}
