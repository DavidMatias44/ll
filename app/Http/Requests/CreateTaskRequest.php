<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\State;
use App\Enums\Priority;

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
            'state' => ['required', Rule::enum(State::class)],
            'priority' => ['required', Rule::enum(Priority::class)],
        ];
    }
}
