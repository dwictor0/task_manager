<div class="row">
    
    @foreach ($deputado as $deputados)
    
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm" style="width: 18rem;">
            <img src="{{ $deputados->imagem_deputado }}" class="card-img-top" alt="Foto do Deputado">
            <div class="card-body">
                <h5 class="card-title">{{ $deputados->nome }}</h5>
                <p class="card-text mb-1">
                    <strong>Partido:</strong> {{ $deputados->partido }}
                </p>
                <p class="card-text mb-1">
                    <strong>UF:</strong> {{ $deputados->uf }}
                </p>
                <p class="card-text">
                    <strong>Total de Tarefas:</strong> {{ $deputados->tarefas_count }}
                </p>
            </div>
        </div>
    </div>

    @endforeach