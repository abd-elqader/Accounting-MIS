<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BranchUpdateRequest extends FormRequest
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
        $branchId = $this->route('branch')?? null ;

        return [
            'name' => 'required|string',
            'parent_id' => [
                'nullable',
                'exists:branches,id',
                Rule::notIn([$branchId]),
            ],
            'company_id' => 'required|exists:companies,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __("app.name"),
            'parent_id' => __("app.parent_id"),
            'company_id' => __("app.company_id"),

        ];
    }

    public function messages()
    {
        return [
            'parent_id.not_in' => __('app.parent_id_not_in'),
        ];
    }
}
