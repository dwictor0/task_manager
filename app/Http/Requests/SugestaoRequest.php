<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SugestaoRequest extends FormRequest
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
            'titulo' => ['required', 'max:255', 'regex:/^[\p{L}\p{M}\s.,?!\'"-]+$/u'],
            'descricao' => ['required', 'max:255', 'regex:/^[\p{L}\p{M}\s.,?!\'"-]+$/u'],
        ];
    }

    public function messages()
    {
        return [
          'titulo.required' => 'O título é obrigatório para criar uma sugestão.',
          'titulo.max' => 'O título da sugestão não pode ter mais de 255 caracteres.',
          'titulo.regex' => 'O título da sugestão está em um formato invalido.',
          'descricao.max' => 'A descrição não conter mais de 255 caracteres.',
          'descricao.required' => 'Não é possivel criar uma sugestão sem que a descrição esteja presente',
          'descricao.regex' => 'A descrição está em um formato invalido.',
        ];
    }
}
