<div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-header bg-dark text-white">
          <h3 class="card-title mb-0">Lista de Tarefas</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered mb-0">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Cód.</th>
                  <th scope="col">Título</th>
                  <th scope="col">Descrição</th>
                  <th scope="col">Status</th>
                  <th scope="col">Prioridade</th>
                  <th scope="col">Data de Vencimento</th>
                  <th scope="col" class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tarefas as $tarefa)
                  <tr>
                    <td>{{ $tarefa->id }}</td>
                    <td>{{ $tarefa->titulo }}</td>
                    <td>{{ $tarefa->descricao }}</td>
                    <td>
                      <span class="badge 
                        @if($tarefa->status === 'concluida') bg-success 
                        @elseif($tarefa->status === 'em_progresso') bg-warning 
                        @else bg-secondary 
                        @endif">
                        {{ ucfirst($tarefa->status) }}
                      </span>
                    </td>
                    <td>
                      <span class="badge 
                        @if($tarefa->prioridade === 'alta') bg-danger 
                        @elseif($tarefa->prioridade === 'media') bg-warning 
                        @else bg-info 
                        @endif">
                        {{ ucfirst($tarefa->prioridade) }}
                      </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($tarefa->data_de_vencimento)->format('d/m/Y') }}</td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('tarefas.edit', $tarefa->id) }}" class="btn btn-outline-primary" title="Editar">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('tarefas.destroy', $tarefa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-outline-danger" title="Excluir">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
           
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>