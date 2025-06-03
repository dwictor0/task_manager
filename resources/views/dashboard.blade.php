<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('System - Gestão de Tarefas') }}
    </h2>


    <div class="row">
      <select name="filtro_status" id="filtro_status">
        <option value="">Selecione</option>
        <option value="Pendente">Pendente</option>
        <option value="Concluida">Concluida</option>
      </select>
    </div>

  </x-slot>

  <div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <table class="min-w-full table-auto border-separate border-spacing-y-2 text-left">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3">Cód.Tarefa</th>
                <th scope="col" class="px-6 py-3">Titulo</th>
                <th scope="col" class="px-6 py-3">Descricao</th>
                <th scope="col" class="px-6 py-3">Status</th>
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
          <td><button type="submit"
            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Restaurar</button></td>
          </form>
          <form action="{{ route('tarefas.destroy', ['tarefa' => $index->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <td><button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Excluir
            Permanentemente</button></td>
          </form>
        @else
          <td><button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"><a
            href="{{ route('tarefas.edit', ['tarefa' => $index->id]) }}">Editar</a></button></td>
          <form action="{{ route('tarefas.destroy', ['tarefa' => $index->id]) }}" method="POST" class="inline">
          @method('DELETE')
          @csrf
          <td><button type="submit" class="sm:px-5">Lixeira</button></td>
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