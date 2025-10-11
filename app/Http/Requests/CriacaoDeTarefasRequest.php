<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriacaoDeTarefasRequest extends FormRequest
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
            'titulo' => ['required', 'max:255', 'regex:/^[a-zA-ZáàãâéèêíïóòôõúçÁÀÃÂÉÈÊÍÏÓÒÔÕÚÇ\s]+$/'],
            'descricao' => ['sometimes','regex:/^[a-zA-ZáàãâéèêíïóòôõúçÁÀÃÂÉÈÊÍÏÓÒÔÕÚÇ\s]+$/'],
            'prioridade' => 'required',
            'data_vencimento' => 'required',
            'status' => 'required',
        ];
    }

    /**
     * Summary of messages
     * @return array{titulo.max: string, titulo.required: string}
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'Para realizar a criação de uma tarefa informe o titulo!',
            'titulo.regex' => 'O texto informado para o titulo não é valido!',
            'descricao.regex' => 'O texto informado para a descrição não é valido!',
            'titulo.max' => 'O titulo da tarefa não pode conter mais de 255 caracteres!',
            'prioridade.required' => 'Não é possivel atualizar sem informar a prioridade da tarefa!',
            'data_vencimento.required' => 'Informe uma data de vencimento para criar uma tarefa!',
            'status.required' => 'Selecione um status para realizar a criação de uma tarefa'
        ];
    }
}
