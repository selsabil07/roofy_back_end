<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Roofy API: Validates property creation from agent/admin dashboards.
 */
class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Property::class);
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['sell', 'rent'])],
            'availability' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string', 'max:5000'],
            'totalArea' => ['nullable', 'numeric', 'min:0'],
            'floor' => ['nullable', 'integer', 'min:0'],
            'location' => ['required', 'string', 'max:255'],
            'rooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'documents' => ['nullable', 'array'],
            'documents.*' => ['string', 'max:255'],
        ];

        // Admins can assign a listing to any agent
        if ($this->user()->isAdmin()) {
            $rules['user_id'] = ['sometimes', 'exists:users,id'];
        }

        return $rules;
    }
}
