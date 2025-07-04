@extends('adminlte::page')

@section('title', 'System - Tarefas')

@section('content_header')




@endsection

@section('content')

<input type="hidden" name="prioridade_alta" id="prioridade_alta" value="{{ $totaisPrioridade['alta'] ?? 0  }}">
<input type="hidden" name="prioridade_media" id="prioridade_media" value="{{  $totaisPrioridade['media'] ?? 0  }}">
<input type="hidden" name="prioridade_baixa" id="prioridade_baixa" value="{{  $totaisPrioridade['baixa'] ?? 0  }}">


<div class="card">
  <div class="card-header">
    <h3 class="card-title">Gráfico de Tarefas - Prioridade</h3>
  </div>
  <div class="card-body">
    <canvas id="tarefasChart" style="height: 250px;"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="info-box">
  <span class="info-box-icon bg-danger"><i class="fas fa-tasks"></i></span>

  <div class="info-box-content">
    <span class="info-box-text">Tarefas Pendentes</span>
    <span class="info-box-number">{{ $totaisStatus['pendente'] ?? 0 }}</span>
  </div>
</div>
<div class="info-box">
  <span class="info-box-icon bg-success"><i class="fas fa-tasks"></i></span>
 
  <div class="info-box-content">
    <span class="info-box-text">Tarefas Concluidas</span>
    <span class="info-box-number">{{ $totaisStatus['concluida'] ?? 0 }}</span>
  </div>
</div>

<div class="info-box">
  <span class="info-box-icon bg-warning"><i class="fas fa-tasks"></i></span>

  <div class="info-box-content">
    <span class="info-box-text">Tarefas Em Andamento</span>
    <span class="info-box-number">{{ $totaisStatus['em_progresso'] ?? 0 }}</span>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
  const ctx = document.getElementById('tarefasChart').getContext('2d');
  let a  = $('#prioridade_alta').val();
  let b  = $('#prioridade_media').val();
  let c  = $('#prioridade_baixa').val();
  console.log(a);
  
  const tarefasChart = new Chart(ctx, {
    type: 'bar', // pode ser 'line', 'pie', etc.
    data: {
      labels: ['Alta', 'Média', 'Baixa'], // categorias
      datasets: [{
        label: 'Quantidade de Tarefas',
        data: [a, b, c], // números que representam os dados
        backgroundColor: [
          'rgba(220, 53, 69, 0.7)', // vermelho (alta)
          'rgba(255, 193, 7, 0.7)',  // amarelo (média)
          'rgba(23, 162, 184, 0.7)'  // azul (baixa)
        ],
        borderColor: [
          'rgba(220, 53, 69, 1)',
          'rgba(255, 193, 7, 1)',
          'rgba(23, 162, 184, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

 </script>
@endsection
