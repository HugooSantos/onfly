<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo name é obrigatório.',
            'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo e-mail informado não é válido',
            'email.unique' => 'O campo e-mail informado já está em uso',
            'email.max' => 'O campo e-mail deve ter no máximo 255 caracteres',
            'password.required' => 'O campo password é obrigatório',
            'password.min' => 'O campo password deve ter no mínimo 8 caracteres',
            'password.max' => 'O campo password deve ter no máximo 255 caracteres'
        ];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ];
    }
}
