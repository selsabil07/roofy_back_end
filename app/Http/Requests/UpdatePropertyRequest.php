<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Roofy API: Validates property updates from agent/admin dashboards.
 */
class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('property'));
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', Rule::in(['sell', 'rent'])],
            'availability' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string', 'max:5000'],
            'totalArea' => ['nullable', 'numeric', 'min:0'],
            'floor' => ['nullable', 'integer', 'min:0'],
            'location' => ['sometimes', 'string', 'max:255'],
            'rooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['string', 'max:255'],
        ];
    }
}
