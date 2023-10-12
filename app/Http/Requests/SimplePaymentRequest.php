<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimplePaymentRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }
  
    public function rules(): array
    {
        return [
            'fromAccount' => 'required|max:10|min:10',
            'toAccount' => 'required|max:10|min:10',
            'amount' => 'required|gt:0',
        ];
    }
}
