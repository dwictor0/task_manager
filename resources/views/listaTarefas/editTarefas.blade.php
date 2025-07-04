@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="text-center">Editar Tarefa</h1>
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
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title mb-0">Atualizar Tarefa</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('tarefas.update', ['tarefa' => $tarefa->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
              <label for="titulo" class="form-label">Título</label>
              <input type="text" class="form-control" name="titulo" id="titulo"
                value="{{ $tarefa->titulo }}" placeholder="Digite o título">
            </div>

            <div class="form-group mb-3">
              <label for="descricao" class="form-label">Descrição</label>
              <input type="text" class="form-control" name="descricao" id="descricao"
                value="{{ $tarefa->descricao }}" placeholder="Digite a descrição">
            </div>

            <div class="form-group mb-3">
              <label for="data_vencimento">Data de Vencimento</label>
              <input type="date" name="data_vencimento" id="data_vencimento" class="form-control"
                value="{{ $tarefa->data_de_vencimento->format('Y-m-d') }}">
            </div>

            <div class="form-group mb-4">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="{{ $tarefa->status }}" selected>{{ ucfirst($tarefa->status) }}</option>
                <option value="pendente">Pendente</option>
                <option value="em_progresso">Em Progresso</option>
                <option value="concluida">Concluída</option>
              </select>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Atualizar Tarefa
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
