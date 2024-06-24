<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorecustomerProductInvoiceRequest extends FormRequest
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
            'total_invoice' => 'nullable|string',
            'reversed' => 'nullable|string',
            'due_date' => 'nullable|string',
            'creation_date' => 'nullable|string',
            'customer_id' => 'nullable|exists:customers,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'total_invoice' => __("keywords.total_invoice"),
            'reversed' => __("keywords.reversed"),
            'due_date' => __("keywords.due_date"),
            'creation_date' => __("keywords.creation_date"),
            'customer_id' => __("keywords.customer_id"),
        ];
    }
}
