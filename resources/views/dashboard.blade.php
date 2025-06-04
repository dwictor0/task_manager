<x-app-layout>

  <div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        @if(session('success'))
  <div class="alert-success">
    <strong>Sucesso!</strong>
    <p class="mt-2">
      {{ session('success') }}
    </p>
  </div>
@endif
        <x-filter-board></x-filter-board>
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <table class="min-w-full table-auto border-separate border-spacing-y-2 text-left">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3">Cód.Tarefa</th>
                <th scope="col" class="px-6 py-3">Titulo</th>
                <th scope="col" class="px-6 py-3">Descricao</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Data de Criação</th>
                <th scope="col" class="px-6 py-3">Ações</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($indexTarefas as $index)

            <tr class="bg-white dark:bg-gray-800 border rounded">
            <td class="px-6 py-3">{{ $index->id }}</td>
            @if(isset($index->deleted_at))
          <td class="px-6 py-3 text-red-500">{{$index->titulo}} - DELETED</td>
        @else
          <td class="px-6 py-3">{{$index->titulo}}</td>
        @endif
            @if($index->descricao != null)
          <td class="px-6 py-3 whitespace-pre-line break-words">{{$index->descricao}}</td>
        @else
          <td class="px-6 py-3 text-gray-500 italic">N/A</td>
        @endif
            <td class="px-6 py-3 space-x-2">{{$index->status}}</td>
            @if(isset($index->deleted_at))
          <form action="{{ route('tarefas.restore', ['id' => $index->id]) }}" method="POST" class="inline">
          @csrf
          <td><x-restore-button></x-restore-button></td>
          </form>
          <form action="{{ route('tarefas.destroy', ['tarefa' => $index->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <td><x-trash-button> {{ __('Excluir Permanentemente') }}</x-trash-button></td>
          </form>
        @else
          <td class="px-6 py-3">{{ $index->created_at->format('d-m-Y') }}</td>
          <td>
          <a href="{{ route('tarefas.edit', ['tarefa' => $index->id]) }}">
          <x-edit-button></x-edit-button>
          </a>
          </td>
          <form action="{{ route('tarefas.destroy', ['tarefa' => $index->id]) }}" method="POST" class="inline">
          @method('DELETE')
          @csrf
          <td><x-trash-button>{{ __('Excluir') }}</x-trash-button></td>
          </form>
        @endif
            </tr>
        @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
<style>
    .alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 1rem;
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const selectFiltro = document.getElementById("filtro_status");

    
    selectFiltro.addEventListener("change", function () {
      const statusSelecionado = this.value.toLowerCase();
      
      const linhas = document.querySelectorAll("tbody tr");
      
      linhas.forEach(linha => {
        const celulas = linha.getElementsByTagName("td");
        const statusCelula = celulas[3] ? celulas[3].innerText.trim().toLowerCase() : "";
        console.log(statusCelula);
        
        
        if (!statusSelecionado || statusCelula === statusSelecionado) {
          linha.style.display = "";
        } else {
          linha.style.display = "none";
        }
      });
    });
  });
</script>