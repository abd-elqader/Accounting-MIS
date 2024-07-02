<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchStoreRequest extends FormRequest
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
            'parent_id' => 'nullable|exists:branches,id',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __("app.branch_name"),
            'parent_id' => __("app.parent_id"),
            'company_id' => __("app.company_id"),

        ];
    }
}
