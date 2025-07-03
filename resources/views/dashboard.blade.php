@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="text-center">Gerenciamento de Tarefas</h1>
@endsection

@section('content')
  <table class="table table-dark">
    <tr>
    <td>Cód.Tarefa</td>
    <td>Título</td>
    <td>Descrição</td>
    <td>Ações</td>
    </tr>
    <tr>
    @foreach ($tarefas as $tarefa)
      <td>{{ $tarefa->id }}</td>

      <td>{{ $tarefa->titulo }}</td>
      <td>{{ $tarefa->descricao }}</td>
      <td>
      
      <div class="d-flex align">
        
        <div class="trashbutton">
        </div>
        <div class="d-flex gap-3">

        <div>
        <a href="{{ route('tarefas.edit', ['tarefa' => $tarefa->id]) }}">
        <x-edit-button>{{ __('Editar') }}</x-edit-button>
        </a>
        </div>

        <div>

        <form action="{{ route('tarefas.destroy', ['tarefa' => $tarefa->id]) }}" method="POST" class="inline">
        @csrf
        @method('DELETE') 
        <x-trash-button>{{ __('Excluir') }}</x-trash-button>
        </form>

        </div>

        </div>
      </div>
      
      </td>
      </tr>
    @endforeach
  </table>
@endsection