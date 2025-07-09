<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Tarefas</title>
</head>
<body>
<h1>Olá, Usuário #{{ $userId }}</h1>
    <p>Uma nova tarefa foi criada com sucesso!</p>
    <p><strong>Título:</strong> {{ $tarefa->titulo }}</p>
    <p><strong>Descrição:</strong> {{ $tarefa->descricao }}</p>
    <p><strong>Data de Vencimento:</strong> {{ $tarefa->data_de_vencimento }}</p>
    <p><strong>Prioridade:</strong> {{ $tarefa->prioridade }}</p>
</body>
</html>
