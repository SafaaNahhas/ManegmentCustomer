<?php

namespace App\Http\Requests\CustomRequest;

use Illuminate\Foundation\Http\FormRequest;

class FilterByDateRangeRequest extends FormRequest
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
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'start_date.required' => ' تاريخ البدء مطلوبة.',
            'start_date.date'     => 'تاريخ البدء يجب أن يكون تاريخًا صالحًا.',
            'start_date.before_or_equal' => 'تاريخ البدء يجب أن يكون قبل أو يساوي تاريخ الانتهاء.',
            'end_date.required'   => 'معلمة تاريخ الانتهاء مطلوبة.',
            'end_date.date'       => 'تاريخ الانتهاء يجب أن يكون تاريخًا صالحًا.',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد أو يساوي تاريخ البدء.',
        ];
    }
}
