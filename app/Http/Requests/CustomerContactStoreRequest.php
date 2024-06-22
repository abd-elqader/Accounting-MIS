<?php

namespace App\Http\Requests;

use App\Enum\ContactTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class CustomerContactStoreRequest extends FormRequest
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
            'type' => 'required|integer|in:'.ContactTypeEnum::PHONE.','.ContactTypeEnum::EMAIL,
            'contact' => 'required|string',
            'description' => 'nullable|string',
            'customer_id' => 'required|exists:customers,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'type' => __("keywords.type"),
            'contact' => __("keywords.contact"),
            'description' => __("keywords.description"),
            'customer_id' => __("keywords.customer_id"),
        ];
    }
}
