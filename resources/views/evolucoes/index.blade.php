@extends('layouts.app')
@section('title', 'Evoluções - ' . $paciente->nome)

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Evoluções de {{ $paciente->nome }}
    </h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- FORM NOVA EVOLUÇÃO -->
    <div class="bg-white p-5 rounded-xl shadow mb-6 border">
        <form action="{{ route('evolucoes.store', $paciente->id) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-sm">Tipo</label>
                    <select name="tipo" class="w-full mt-1 border-gray-300 rounded">
                        @foreach(App\Models\Evolucao::$tipos as $tipo)
                            <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold text-sm">Data</label>
                    <input type="datetime-local" name="data_registro"
                           class="w-full mt-1 border-gray-300 rounded"
                           value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>
            </div>

            <div class="mt-4">
                <label class="font-semibold text-sm">Conteúdo</label>
                <textarea name="conteudo" rows="4"
                          class="w-full mt-1 border-gray-300 rounded"></textarea>
            </div>

            <button class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Salvar Evolução
            </button>
        </form>
    </div>

    <!-- LISTA DE EVOLUÇÕES -->
    <div class="space-y-4">
        @foreach($evolucoes as $ev)
            <div class="bg-white p-4 rounded-xl shadow border">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-lg">
                        {{ ucfirst($ev->tipo) }}
                    </h3>

                    <div class="flex gap-2">
                        <a href="{{ route('evolucoes.edit', $ev->id) }}"
                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                            Editar
                        </a>

                        <form method="POST" action="{{ route('evolucoes.destroy', $ev->id) }}">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>

                <p class="text-gray-700 mt-2 whitespace-pre-line">{{ $ev->conteudo }}</p>

                <div class="text-xs text-gray-500 mt-2">
                    Registrado em {{ date('d/m/Y H:i', strtotime($ev->data_registro)) }}  
                    • por {{ $ev->profissional->name }}
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
