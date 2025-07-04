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
    <td>Status</td>
    <td>Ações</td>
    </tr>
    <tr>
    @foreach ($index as $tarefa)
      <td>{{ $tarefa->id }}</td>
      @if(isset($tarefa->deleted_at))
      <td>{{ $tarefa->titulo }} - DELETED</td>
      @else
      <td class="px-6 py-3">{{$tarefa->titulo}}</td>
      @endif

      @if($tarefa->descricao != null)
      <td>{{ $tarefa->descricao }}</td>
      @else
      <td class="px-6 py-3 text-gray-500 italic">N/A</td>
      @endif


      <td>{{ $tarefa->status }}</td>
      <td>

      <div class="d-flex align">

      <div class="trashbutton">
      </div>
      <div class="d-flex gap-3">
          <form action="{{ route('tarefas.restore', ['id' => $tarefa->id]) }}" method="POST" class="inline">
          @csrf
          <td><x-restore-button></x-restore-button></td>
          </form>

          <form action="{{ route('tarefas.destroy', ['tarefa' => $tarefa->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <td><x-trash-button>
            {{ __('Excluir Permanentemente') }}
          </x-trash-button></td>
          </form>

      </div>
      </div>

      </td>
      </tr>
    @endforeach
  </table>
@endsection