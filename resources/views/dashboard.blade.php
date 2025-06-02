<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('System - Gestão de Vagas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titulo</th>
      <th scope="col">Descricao</th>
      <th scope="col">Status</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($indexTarefas as $index)
      
    <tr>
      <th scope="row">1</th>
      <td class="sm:px-6">{{$index->titulo}}</td>
      <td class="sm:px-6">{{$index->descricao}}</td>
      <td class="sm:px-6">{{$index->status}}</td>
      <td><button type="submit" class="btn btn-danger sm:px-6"><a href="{{ route('tarefas.edit', ['tarefa' => $index->id]) }}">Editar</a></button></td>
    </tr>
   
    @endforeach
  </tbody>
</table>
</div>
</div>
        </div>
      </div>
    </x-app-layout>
    