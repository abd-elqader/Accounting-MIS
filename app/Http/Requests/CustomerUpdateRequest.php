<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'contact_name' => 'nullable|string',
            'industry_id' => 'nullable|exists:industries,id',
            'country_id' => 'nullable|exists:countries,id',
            'iban' => 'nullable|string',
            'commercial_register' => 'nullable|string',
            'company_name' => 'nullable|string',
            'monthly_expenses' => 'nullable|string',
            'monthly_income' => 'nullable|string',
            'tax_number' => 'nullable|string',
            'taxable' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'contact_name' => __("keywords.contact_name"),
            'industry_id' => __("keywords.industry_id"),
            'country_id' => __("keywords.country_id"),
            'iban' => __("keywords.iban"),
            'commercial_register' => __("keywords.commercial_register"),
            'company_name' => __("keywords.company_name"),
            'monthly_expenses' => __("keywords.monthly_expenses"),
            'monthly_income' => __("keywords.monthly_income"),
            'tax_number' => __("keywords.tax_number"),
            'taxable' => __("keywords.taxable"),
        ];
    }
}
