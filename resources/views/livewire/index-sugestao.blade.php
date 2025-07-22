<div>
    <div class="mb-4 d-flex justify-content-end">
        <a href="{{ route('sugestao.save') }}" class="btn btn-primary shadow-sm">
            <i class="fas faa-plus-circle mr-1"></i> Nova Sugestão
        </a>
    </div>

    <div class="row">
        @forelse ($sugestoesAtivas as $sugestao)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb mr-2"></i> {{ $sugestao->titulo }}
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="card-text text-muted mb-4" style="min-height: 70px;">
                            {{ $sugestao->descricao }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <form action="{{ route('sugestao.update') }}" method="POST" class="mb-0">
                                @csrf
                                <input type="hidden" name="sugestao_id" value="{{ $sugestao->id }}">
                                <button type="submit" class="btn btn-outline-success btn-sm shadow-sm">
                                    <i class="fas fa-thumbs-up mr-1"></i> Votar
                                </button>
                            </form>

                            <span class="badge badge-pill badge-primary px-3 py-2">
                                <i class="fas fa-vote-yea mr-1"></i> {{ $sugestao->total_votos }} voto{{ $sugestao->total_votos != 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle mr-2"></i> Nenhuma sugestão encontrada.
                </div>
            </div>
        @endforelse
    </div>
</div> <!-- <- esse é o container raiz necessário -->
