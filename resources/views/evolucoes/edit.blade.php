@extends('layouts.app')
@section('title', 'Editar Evolução')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Editar Evolução</h1>

    <form action="{{ route('evolucoes.update', $evolucao->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="font-semibold text-sm">Tipo</label>
                <select name="tipo" class="w-full mt-1 border-gray-300 rounded">
                    @foreach(App\Models\Evolucao::$tipos as $tipo)
                        <option value="{{ $tipo }}" 
                            {{ $evolucao->tipo == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-semibold text-sm">Data</label>
                <input type="datetime-local" name="data_registro"
                       value="{{ date('Y-m-d\TH:i', strtotime($evolucao->data_registro)) }}"
                       class="w-full mt-1 border-gray-300 rounded">
            </div>
        </div>

        <div class="mt-4">
            <label class="font-semibold text-sm">Conteúdo</label>
            <textarea name="conteudo" rows="5"
                      class="w-full mt-1 border-gray-300 rounded">{{ $evolucao->conteudo }}</textarea>
        </div>

        <div class="mt-6 flex gap-3">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Salvar</button>
            <a href="{{ route('evolucoes.index', $evolucao->paciente_id) }}" class="px-6 py-2 rounded-lg border">
                Cancelar
            </a>
        </div>
    </form>

</div>
@endsection
