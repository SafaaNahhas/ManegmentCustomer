<?php

namespace App\Http\Requests\PaymentRequest;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'customer_id'  => 'required|exists:customers,id',
            'amount'       => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'status'       => 'required|in:paid,unpaid',
        ];
    }
     /**
     * Get custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'customer_id.required' => 'The customer ID is required.',
            'customer_id.exists'   => 'The specified customer does not exist.',
            'amount.required'      => 'The payment amount is required.',
            'amount.numeric'       => 'The payment amount must be a number.',
            'payment_date.required'=> 'The payment date is required.',
            'status.required'      => 'The payment status is required.',
            'status.in'            => 'The payment status must be either paid or unpaid.',
        ];
    }
  
}
