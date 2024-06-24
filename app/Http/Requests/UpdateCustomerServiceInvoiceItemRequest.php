<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerServiceInvoiceItemRequest extends FormRequest
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
            'count' => 'required|string',
            'price' => 'required|string',
            'total_items_cost' => 'required|string',
            'CSI_id' => 'required|exists:customer_service_invoices,id',
            'service_id' => 'required|exists:services,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'count' => __("keywords.count"),
            'price' => __("keywords.price"),
            'total_items_cost' => __("keywords.total_items_cost"),
            'CSI_id' => __("keywords.CSI_id"),
            'service_id' => __("keywords.service_id"),
        ];
    }
}
