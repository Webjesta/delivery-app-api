<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Only allow users with the "seller" role to create/update products.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'seller';
    }

    /**
     * Validation rules for creating or updating a product.
     *
     * @return array<string,\Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
        ];
    }
}
