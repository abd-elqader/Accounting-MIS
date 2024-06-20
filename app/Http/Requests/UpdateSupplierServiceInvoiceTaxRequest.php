<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierServiceInvoiceTaxRequest extends FormRequest
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
            'name' => 'required|string',
            'value' => 'required|string',
            'type' => 'required|string',
            'SSI_id' => 'required|exists:supplier_service_invoices,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __("keywords.name"),
            'value' => __("keywords.value"),
            'type' => __("keywords.type"),
            'SSI_id' => __("keywords.SSI_id"),
        ];
    }
}
