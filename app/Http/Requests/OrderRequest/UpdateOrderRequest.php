<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'customer_id'   => 'sometimes|exists:customers,id',
            'product_name'  => 'sometimes|string|max:255',
            'quantity'      => 'sometimes|integer|min:1',
            'price'         => 'sometimes|numeric|min:0',
            'status'        => 'sometimes|in:completed,pending,cancelled',
            'order_date'    => 'sometimes|date',
        ];
    }
}
