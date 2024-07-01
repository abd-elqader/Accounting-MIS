<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxStoreRequest extends FormRequest
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
            'name' => 'required|string|unique:taxes,name',
            'value' => 'required|numeric',
            'value_type' => 'required|string|in:percentage,amount',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __("app.name"),
            'value' => __("app.value"),
            'value_type' => __("app.type"),
        ];
    }
}
