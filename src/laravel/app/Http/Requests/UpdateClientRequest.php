<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id;
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes','required','email', Rule::unique('clients','email')->ignore($clientId)],
            'phone' => 'nullable|string|max:30',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
        ];
    }
}
