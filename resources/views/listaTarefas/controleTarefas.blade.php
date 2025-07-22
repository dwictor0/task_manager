@extends('adminlte::page')

@section('title', 'System - Tarefas')

@section('content_header')
  <h1 class="text-center">Gerenciamento de Tarefas</h1>
  <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
  <livewire:dashboard-container></livewire:dashboard-container>
@endsection
@section('adminlte_js')
  <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

  <script>

    Pusher.logToConsole = false;

    var pusher = new Pusher('2c0d6c5c3b525a1e9679', {
    cluster: 'us2',
    authEndpoint: '/pusher/auth',
    auth: {
      headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    }
    });

    var userId = @json(auth()->id());
    var channel = pusher.subscribe('private-usuario.' + userId);

    channel.bind('evento-teste', function (data) {
    window.dispatchEvent(new CustomEvent('evento', { detail: data }));

    });

  </script>
@endsection