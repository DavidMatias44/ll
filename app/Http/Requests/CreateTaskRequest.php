<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'state' => 'required',
            'priority' => 'required',
        ];
    }
}
