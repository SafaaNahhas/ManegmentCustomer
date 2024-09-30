<?php

namespace App\Http\Requests\CustomRequest;

use Illuminate\Foundation\Http\FormRequest;

class FilterByStatusRequest extends FormRequest
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
    public function rules()
    {
        return [
            'status' => 'required|string|in:completed,pending,cancelled',
        ];
    }

    /**
     *
     * @return array
     */
    public function messages()
    {
        return [
            'status.required' => ' الحالة مطلوبة.',
            'status.string'   => 'الحالة يجب أن تكون نصًا.',
            'status.in'       => 'الحالة يجب أن تكون واحدة من: completed, pending, cancelled.',
        ];
    }
}
