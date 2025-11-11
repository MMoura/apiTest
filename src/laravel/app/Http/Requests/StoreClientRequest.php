<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:30',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
        ];
    }
}
