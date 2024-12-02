<?php

namespace App\Http\Requests\Astrologer;

use Illuminate\Foundation\Http\FormRequest;

class StoreAstrologerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:astrologers,email',
        ];
    }

    public function messages()
    {
        return [
            'user_id.exists' => 'The selected user does not exist.',
            'email.unique' => 'An astrologer with this email already exists.'
        ];
    }
}
