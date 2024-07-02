<?php

namespace App\Http\Requests;

use App\DTO\SupplierServiceInvoice\SupplierServiceInvoiceDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoresupplierServiceInvoiceRequest extends FormRequest
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
            'due_date' => 'required|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'currency_id' => 'required|exists:currencies,id',

            'invoice_items_service_id'=>'nullable|array',
            'invoice_items_service_id.*'=>'required|integer|exists:services,id',
            
            'invoice_items_count'=>'nullable|array',
            'invoice_items_count.*'=>'required|integer|min:1',

            'invoice_taxes_tax_id'=>'nullable|array',
            'invoice_taxes_tax_id.*'=>'required|integer|exists:taxes,id',

        ];
    }

    public function attributes(): array
    {
        return [
            'total_invoice' => __("keywords.total_invoice"),
            'reversed' => __("keywords.reversed"),
            'due_date' => __("keywords.due_date"),
            'creation_date' => __("keywords.creation_date"),
            'supplier_id' => __("keywords.supplier_id"),
        ];
    }
}
