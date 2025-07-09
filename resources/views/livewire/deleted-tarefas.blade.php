<div class="row">
  @forelse ($tarefasDeletada as $tarefa)
    <div class="col-md-6 col-lg-4 mb-4">
    <div class="card border-danger shadow">
      <div class="card-header bg-danger text-white d-flex justify-content-between">
      <span><i class="fas fa-exclamation-circle mr-2"></i>Tarefa #{{ $tarefa->id }}</span>
      <span class="badge badge-light text-dark">{{ ucfirst($tarefa->status) }}</span>
      </div>
      <div class="card-body">
      <h5 class="card-title">{{ $tarefa->titulo }}</h5>
      <p class="card-text text-muted">{{ $tarefa->descricao }}</p>

      <p><strong>Prioridade:</strong>
        <span class="badge 
          @if($tarefa->prioridade === 'alta') badge-danger 
      @elseif($tarefa->prioridade === 'media') badge-warning 
        @else badge-info 
      @endif">
        {{ ucfirst($tarefa->prioridade) }}
        </span>
      </p>

      <p><strong>Vencimento:</strong>
        {{ $tarefa->data_de_vencimento->format('d/m/Y') }}
      </p>

      <div class="d-flex justify-content-between">
        <form action="{{ route('tarefas.restore', $tarefa->id) }}" method="POST" class="mr-2 w-100 me-1">
        @csrf
        <button type="submit" class="btn btn-success btn-sm btn-block">
          <i class="fas fa-undo-alt"></i> Restaurar
        </button>
        </form>

        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" class="w-100 ms-1"
        onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa permanentemente? Esta ação não pode ser desfeita.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm btn-block">
          <i class="fas fa-trash"></i> Excluir 
        </button>
        </form>
      </div>
      </div>
    </div>
    </div>
  @empty
    <div class="col-12">
    <div class="alert alert-info text-center">
      Nenhuma tarefa deletada encontrada.
    </div>
    </div>
  @endforelse
</div>