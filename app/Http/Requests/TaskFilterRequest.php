<?php

namespace App\Http\Requests;

use App\Enums\Tasks\Priority;
use App\Enums\Tasks\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
