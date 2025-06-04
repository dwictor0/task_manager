<x-app-layout>
  <div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm ">
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
              @foreach ($indexTarefasDeleted as $index)

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
          <td><x-trash-button>
            {{ __('Excluir Permanentemente') }}
          </x-trash-button></td>
          </form>
        @else
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