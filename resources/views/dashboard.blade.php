@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="text-center">Gerenciamento de Tarefas</h1>
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
    <strong>
      <i class="fas fa-check-circle me-2"></i> Sucesso!
    </strong>
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@endsection

@section('content')
 <livewire:dashboard-container></livewire:dashboard-container>
  
 <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('2c0d6c5c3b525a1e9679', {
      cluster: 'us2'
    });

    var channel = pusher.subscribe('canal-teste');
    channel.bind('evento-teste', function(data) {
      console.log('Hello Channel');
      
    });
  </script>
@endsection
