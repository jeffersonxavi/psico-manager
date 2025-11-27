<div class="bg-white p-6 rounded-2xl shadow border space-y-4">

    {{-- TÍTULO DA SESSÃO --}}
    <div class="flex justify-between items-center">
        <span class="font-semibold">
            Sessão em {{ date('d/m/Y H:i', strtotime($sessao->data_sessao)) }}
        </span>

        <div class="flex items-center gap-2">
            <span class="text-gray-500 text-sm">
                Registrada por {{ $sessao->profissional->name }}
            </span>

            <a href="{{ route('sessoes.edit', $sessao->id) }}"
               class="px-3 py-1 bg-yellow-500 text-white rounded-lg text-xs hover:bg-yellow-600">
                Editar
            </a>

            <form method="POST" action="{{ route('sessoes.destroy', $sessao->id) }}">
                @csrf @method('DELETE')
                <button class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs hover:bg-red-700"
                    onclick="return confirm('Excluir sessão?');">
                    Excluir
                </button>
            </form>
        </div>
    </div>

    {{-- CONTEÚDO DA SESSÃO --}}
    @if($sessao->conteudo)
        <p class="text-gray-800 whitespace-pre-line">{{ $sessao->conteudo }}</p>
    @endif

    {{-- FORM DE REGISTROS --}}
    @include('registros.partials.form', ['sessao' => $sessao])

    {{-- REGISTROS --}}
    @if($sessao->registros->count())
        <div class="space-y-3 mt-4">
            @foreach($sessao->registros as $registro)
                @include('registros.partials.registro-item', compact('registro'))
            @endforeach
        </div>
    @endif

</div>
