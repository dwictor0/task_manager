<style>
  .alert-error {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 1rem;
  }
</style>
<x-app-layout>
  <div class="py-12">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white dark:bg-gray-800 shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">Edição de tarefa</h2>
        @if($errors->any())
        <div class="alert-error">
          <strong>Alerta!</strong>
          <ul class="list-disc list-inside mt-2">
          @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
          </ul>
        </div>
    @endif
        <form action="{{ route('tarefas.update', ['tarefa' => $tarefa->id]) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título</label>
            <input type="text" name="titulo" id="titulo"
              class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 text-white"
              value="{{ $tarefa->titulo }}">
          </div>

          <div class="mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
            <textarea name="descricao" id="descricao" rows="5"
              class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 dark:bg-gray-700 text-white resize-y">{{$tarefa->descricao }}</textarea>
          </div>

          <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
              Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>