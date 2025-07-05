@extends('adminlte::page')

@section('title', 'System - Tarefas')

@section('content_header')
  <h1 class="text-center text-danger">
    <i class="fas fa-trash-alt"></i> Tarefas Deletadas
  </h1>
@endsection

@section('content')
 <livewire:deleted-tarefas></livewire:deleted-tarefas>
@endsection
