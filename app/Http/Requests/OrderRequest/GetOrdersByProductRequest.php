<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Foundation\Http\FormRequest;

class GetOrdersByProductRequest extends FormRequest
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
            'product_name' => $this->route('productName'),
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
            'product_name' => 'required|string|max:255',
        ];
    }
      /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'product_name.required' => 'اسم المنتج مطلوب.',
            'product_name.string' => 'اسم المنتج يجب أن يكون نصًا.',
            'product_name.max' => 'اسم المنتج يجب ألا يتجاوز 255 حرفًا.',
        ];
    }
}
