<?php

namespace App\Http\Requests\OrderRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer_id'   => 'required|exists:customers,id',
            'product_name'  => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'price'         => 'required|numeric|min:0',
            'status'        => 'required|in:completed,pending,cancelled',
            'order_date'    => 'required|date',
        ];
    }
}
