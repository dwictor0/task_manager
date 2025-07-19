<div class="row">
    @foreach ($senador as $senadores)
    
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm" style="width: 18rem;">
            <img src="{{ $senadores->imagem_senador }}" class="card-img-top" alt="Foto do Senador">
            <div class="card-body">
                <h5 class="card-title">{{ $senadores->nome }}</h5>
                <p class="card-text mb-1">
                    <strong>Partido:</strong> {{ $senadores->partido }}
                </p>
                <p class="card-text mb-1">
                    <strong>UF:</strong> DF
                </p>
                <p class="card-text">
                    <strong>Total de Tarefas:</strong> 0
                </p>
                <a href="#" class="btn btn-primary btn-sm">
                    <i class="fas fa-info-circle mr-1"></i> Detalhes
                </a>
            </div>
        </div>
    </div>

    @endforeach