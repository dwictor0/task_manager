<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizaTarefasRequest extends FormRequest
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
            'titulo' => ['required', 'max:255', 'regex:/^[a-zA-ZáàãâéèêíïóòôõúçÁÀÃÂÉÈÊÍÏÓÒÔÕÚÇ]+$/'],
            'descricao' => ['sometimes', 'regex:/^[a-zA-ZáàãâéèêíïóòôõúçÁÀÃÂÉÈÊÍÏÓÒÔÕÚÇ]+$/'],
            'data_vencimento' => 'required|date',
        ];
    }

    /**
     * Summary of messages
     * @return array{titulo.max: string, titulo.required: string}
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'Não é possivel atualizar uma tarefa sem informar o titulo!.',
            'titulo.max' => 'A tarefa não pode ser atualizada se o titulo tiver mais de 255 caracteres!.',
            'descricao.regex' => 'O texto informado para a descrição não é valido!',
            'titulo.regex' => 'O texto informado para o titulo não é valido!',
            'data_vencimento.required' => 'Informe uma data para atualizar a tarefa!.',
            'data_vencimento.date' => 'A data informada não é valida!.'
        ];
    }
}
