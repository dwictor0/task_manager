@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="text-center">Gerenciamento de Tarefas</h1>
@endsection

@section('content')
  <form action="{{ route('tarefas.update', ['tarefa' => $tarefa->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
    <label for="titulo" class="form-label ">Titulo</label>
    <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="emailHelp"
      value="{{ $tarefa->titulo }}">
    </div>

    <div class="mb-3">
    <label for="descricao" class="form-label">Descrição</label>
    <input type="text" class="form-control" name="descricao" id="descricao" value="{{ $tarefa->descricao }}">
    </div>

    <div class="mb-6">
    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
    <select name="status" id="status"
      class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 text-white">
      <option value="{{ $tarefa->status }}" selected>Selecione o status</option>
      <option value="pendente">Pendente</option>
      <option value="em_progresso">Em Progresso</option>
      <option value="concluida">Concluída</option>
    </select>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
  </form>
@endsection