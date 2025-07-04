@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="text-center">Gerenciamento de Tarefas</h1>
@endsection

@section('content')
  <form action="{{ route('tarefas.store') }}" method="POST">
          @csrf

    <div class="mb-3">
    <label for="titulo" class="form-label">Titulo</label>
    <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Descrição</label>
    <input type="text" class="form-control" name="descricao" id="descricao">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

  </form>
@endsection