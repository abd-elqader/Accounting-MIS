<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
            'slug' => 'required|string',
            'code' => 'required|string',
            'currency_id' => 'required|integer|exists:currencies,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __("app.company_name"),
            'slug' => __("app.company_code"),
            'code' => __("app.company_slug"),
            'currency_id' => __("app.currency"),
        ];
    }
}
