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
@endsection

@section('content')
   

<livewire:index-sugestao></livewire:index-sugestao>
@endsection
