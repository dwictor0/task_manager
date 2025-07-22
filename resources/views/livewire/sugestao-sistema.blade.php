 <div class="row justify-content-center pt-4">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title mb-0">Sugestão</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('sugestao.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
              <label for="titulo">Titulo</label>
              <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Informe o titulo da sugestão">
            </div>

            <div class="form-group mb-3">
              <label for="descricao">Descrição</label>
              <textarea class="form-control" name="descricao" id="descricao" rows="3" placeholder="Informe a descrição da sugestão"></textarea>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-success">
                <i class="fas fa-check"></i> Enviar Sugestão
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>