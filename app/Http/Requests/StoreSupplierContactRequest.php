<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierContactRequest extends FormRequest
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
            'type' => 'nullable|string',
            'contact' => 'nullable|string',
            'description' => 'nullable|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => __("keywords.type"),
            'contact' => __("keywords.contact"),
            'description' => __("keywords.description"),
            'supplier_id' => __("keywords.supplier_id"),
        ];
    }
}
