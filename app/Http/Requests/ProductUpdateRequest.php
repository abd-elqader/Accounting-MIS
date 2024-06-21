<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'brand' => 'required|string',
            'tax' => 'required|numeric',
            'taxable' => 'nullable|string',
            'description' => 'required|string',
            'stock' => 'required|integer',
            // 'type' => 'required|string',
            'daily_income' => 'required|numeric',
            'weekly_income' => 'required|numeric',
            'monthly_income' => 'required|numeric',
            'yearly_income' => 'required|numeric',
            'category_id' => 'required|integer|exists:categories,id',
            'department_id' => 'required|integer|exists:departments,id',

            'unit_prices_price'=>'nullable|array',
            'unit_prices_price.*'=>'required|numeric',
            'unit_prices_currency_id'=>'nullable|array',
            'unit_prices_currency_id.*'=>'required|integer|exists:currencies,id',

        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __("app.name"),
        ];
    }
}
