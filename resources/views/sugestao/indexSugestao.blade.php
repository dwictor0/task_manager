@extends('adminlte::page')

@section('title', 'System - Tarefas')

@section('content_header')
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
<div class="mb-3">
    <a href="{{ route('sugestao.save') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle mr-1"></i> Fazer Sugestão
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        @foreach ($sugestoesAtivas as $sugestao)
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lightbulb mr-2"></i> {{ $sugestao->titulo }}
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                   {{ $sugestao->descricao }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <form action="{{ route('sugestao.update') }}" method="post">
                        @csrf
                            <button class="btn btn-outline-success btn-sm" >
                                <i class="fas fa-thumbs-up"></i> Votar
                                <input type="hidden" name="sugestao_id" id="sugestao_id" value="{{ $sugestao->id }}">
                            </button>
                        </form>
                    <span class="badge badge-pill badge-primary">
                        <i class="fas fa-vote-yea"></i> Votos {{ $sugestao->total_votos }}
                    </span>
                </div>
            </div>
        </div>
    </div>
        @endforeach

</div>
@endsection
