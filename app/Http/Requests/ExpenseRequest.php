<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:191'],
            'amount' => ['required', 'numeric', 'min:0', 'not_in:0'],
            'date' => ['required', 'date_format:Y-m-d', 'before_or_equal:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O campo description é obrigatória.',
            'description.string' => 'O campo description deve ser uma string.',
            'description.max' => 'O campo description deve ter no máximo 191 caracteres.',
            'amount.required' => 'O campo amount é obrigatório.',
            'amount.numeric' => 'O campo amount deve ser um número.',
            'amount.min' => 'O campo amount deve ser maior que 0.',
            'amount.not_in' => 'O campo amount deve ser maior que 0.',
            'date.required' => 'O campo date é obrigatória.',
            'date.date_format' => 'O campo date deve ser no formato YYYYY-MM-DD exemplo 2023-01-02.',
            'date.before_or_equal' => 'O campo date não pode ser futura.',
        ];
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'amount' => $this->amount,
            'date' => $this->date,
            'user_id' => Auth::User()->id
        ];
    }
}