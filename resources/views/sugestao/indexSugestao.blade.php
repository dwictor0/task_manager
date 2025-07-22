@extends('adminlte::page')

@section('title', 'System - Tarefas')

@section('content_header')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
            <strong><i class="fas fa-check-circle mr-2"></i> Sucesso!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded" role="alert">
    <strong>
      <i class="fas fa-exclamation-circle me-2"></i> Erro!
    </strong>
  
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
@endsection

@section('content')
   

<livewire:index-sugestao></livewire:index-sugestao>
@endsection
