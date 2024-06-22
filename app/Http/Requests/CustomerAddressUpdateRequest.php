<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAddressUpdateRequest extends FormRequest
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
            'postal_code' => 'nullable|string',
            'description' => 'nullable|string',
            'customer_id' => 'nullable|exists:customers,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => __("keywords.type"),
            'postal_code' => __("keywords.postal_code"),
            'description' => __("keywords.description"),
            'supplier_id' => __("keywords.supplier_id"),
        ];
    }
}
