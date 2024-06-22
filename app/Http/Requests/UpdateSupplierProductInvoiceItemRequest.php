<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierProductInvoiceItemRequest extends FormRequest
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
            'SPI_id' => 'required|exists:supplier_product_invoices,id',
            'product_id' => 'required|exists:supplier_product_invoices,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'count' => __("keywords.count"),
            'price' => __("keywords.price"),
            'total_items_cost' => __("keywords.total_items_cost"),
            'SPI_id' => __("keywords.SPI_id"),
            'product_id' => __("keywords.product_id"),
        ];
    }
}
