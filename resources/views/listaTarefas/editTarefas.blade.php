<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
    <form action="{{ route('tarefas.update',['tarefa' => $editTarefa->id])}}" method="POST">
    @method('PUT')
    @csrf
 <div class="container">

   <div class="card">
     <div class="card-header">
    Crie uma vaga
  </div>
  <div class="card-body">
      <label for="titulo" class="form-label">Titulo</label>
    <input type="text" class="form-control" name="titulo" id="titulo" aria-describedby="emailHelp" value="{{ $editTarefa->titulo }}">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    <label for="descricao" class="form-label">Descrição</label>
    <input type="text" class="form-control" name="descricao" id="descricao" value="{{ $editTarefa->descricao }}">
 
  <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>
</div>

</form>
</body>
</html>