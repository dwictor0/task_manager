@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
  <h1 class="text-center">Gerenciamento de Tarefas</h1>
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
          <h3 class="card-title mb-0">Nova Tarefa</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('tarefas.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
              <label for="titulo">Título</label>
              <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Digite o título da tarefa">
            </div>

            <div class="form-group mb-3">
              <label for="descricao">Descrição</label>
              <textarea class="form-control" name="descricao" id="descricao" rows="3" placeholder="Descreva a tarefa"></textarea>
            </div>

            <div class="form-group mb-3">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="" selected disabled>Selecione o status</option>
                <option value="pendente">Pendente</option>
                <option value="em_progresso">Em Progresso</option>
                <option value="concluida">Concluída</option>
              </select>
            </div>

            <div class="form-group mb-3">
              <label for="prioridade">Prioridade</label>
              <select name="prioridade" id="prioridade" class="form-control">
                <option value="" selected disabled>Selecione a prioridade</option>
                <option value="baixa">Baixa</option>
                <option value="media">Média</option>
                <option value="alta">Alta</option>
              </select>
            </div>

            <div class="form-group mb-4">
              <label for="data_vencimento">Data de Vencimento</label>
              <input type="date" name="data_vencimento" id="data_vencimento" class="form-control">
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Salvar Tarefa
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
