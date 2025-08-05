<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\Priority;
use App\Enums\State;

class TaskFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'state' => ['nullable', Rule::in([State::TODO, State::IN_PROGRESS, State::COMPLETED])],
            'priority' => ['nullable', Rule::in([Priority::LOW, Priority::MEDIUM, Priority::HIGH])],
        ];
    }
}
