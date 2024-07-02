<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'commercial_register' => 'required',
            'logo' => 'nullable',
            'start_of_finanicail_year' => 'required',
            'end_of_financial_year' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __("app.name"),
            'logo' => __("app.logo"),
            'commercial_register' => __("app.commercial_register"),
            'start_of_finanicail_year' => __("app.start_of_finanicail_year"),
            'end_of_financial_year' => __("app.end_of_financial_year"),
        ];
    }
}
