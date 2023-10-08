<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
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
            'full_name' => 'required|min:3|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => 'required|min:5|max:255',
            'cpf' => 'required|min:14|max:14|unique:users',
            'nationality' => 'required|min:3|max:100',
            'contact_number' => 'required|min:13|max:13',
            'birth_date' => 'required',
            'account_type' => 'required'
        ];
    }
}
