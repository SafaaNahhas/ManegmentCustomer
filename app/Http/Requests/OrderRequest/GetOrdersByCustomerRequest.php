<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Foundation\Http\FormRequest;

class GetOrdersByCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'customer_id' => $this->route('customerId'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|integer|exists:customers,id',
        ];
    }
    public function messages()
    {
        return [
            'customer_id.required' => 'معرف العميل مطلوب.',
            'customer_id.integer' => 'معرف العميل يجب أن يكون عددًا صحيحًا.',
            'customer_id.exists' => 'معرف العميل غير موجود.',
        ];
    }
}
