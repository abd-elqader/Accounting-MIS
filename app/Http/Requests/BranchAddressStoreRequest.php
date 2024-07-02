<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchAddressStoreRequest extends FormRequest
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
            'branch_id' => 'required|exists:branches,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => __("keywords.type"),
            'postal_code' => __("keywords.postal_code"),
            'branch_id' => __("keywords.branch_id"),
        ];
    }
}
