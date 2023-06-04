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
            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser uma string.',
            'description.max' => 'A descrição deve ter no máximo 191 caracteres.',
            'amount.required' => 'O valor da despesa é obrigatório.',
            'amount.numeric' => 'O valor da despesa deve ser um número.',
            'amount.min' => 'O valor da despesa deve ser maior que 0.',
            'amount.not_in' => 'O valor da despesa deve ser maior que 0.',
            'date.required' => 'A data da despesa é obrigatória.',
            'date.date_format' => 'A data da despesa deve ser no formato YYYYY-MM-DD exemplo 2023-01-02.',
            'date.before_or_equal' => 'A data da despesa não pode ser futura.',
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