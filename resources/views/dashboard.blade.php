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


<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
 <livewire:dashboard-container></livewire:dashboard-container>

 <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
 
  <script>

    
    Pusher.logToConsole = true;

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
    channel.bind('evento-teste', function(data) {
          window.livewire.emit('tarefaAtualizada');

        console.log('Tarefa atualizada:', data.tarefa);
      
    });
  </script>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

<script>
  
  const ctx = document.getElementById('tarefasChart').getContext('2d');
  const tarefasChart = new Chart(ctx, {
    
  });


  Pusher.logToConsole = true;

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

  channel.bind('evento-teste', function(data) {
    
    if(window.livewire) {
      window.livewire.emit('tarefaAtualizada');
    }
    console.log('Tarefa atualizada:', data.tarefa);
  });
</script>
@endsection
