<div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl">
    <!-- Header da sessão -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-7 py-5 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                    <h3 class="text-lg font-bold text-gray-800">
                        Sessão • {{ $sessao->data_sessao->format('d \d\e F \d\e Y \à\s H:i') }}
                    </h3>
                </div>
                <span class="text-sm text-gray-600 bg-white/80 px-3 py-1 rounded-full font-medium">
                    por {{ $sessao->profissional->name }}
                </span>
            </div>

            <div class="flex items-center gap-3">
                <button @click="editarSessao({
                    id: {{ $sessao->id }},
                    data_sessao: '{{ $sessao->data_sessao->format('Y-m-d\TH:i') }}',
                    conteudo: @js($sessao->conteudo)
                })"
                    class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar sessão
                </button>

                <form method="POST" action="{{ route('sessoes.destroy', $sessao->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Tem certeza que deseja excluir esta sessão?')" 
                        class="p-2.5 text-red-600 hover:bg-red-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.375 2.375 0 0116.138 21H7.862a2.375 2.375 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Conteúdo da sessão (se houver) -->
    @if($sessao->conteudo)
        <div class="px-7 py-5 bg-gray-50 border-b border-gray-200">
            <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm font-medium">
                {!! nl2br(e($sessao->conteudo)) !!}
            </p>
        </div>
    @endif

    <!-- Lista de registros -->
    <div class="p-7 space-y-5">
        @if($sessao->registros->count())
            @foreach($sessao->registros as $registro)
                @include('registros.partials.registro-item', compact('registro', 'sessao'))
            @endforeach
        @else
            <p class="text-center text-gray-400 italic py-8">Nenhum registro adicionado ainda.</p>
        @endif
    </div>

    <!-- Formulário de novo registro (sempre visível, mas elegante) -->
    <div class="border-t border-gray-200 bg-gray-50/50">
        @include('registros.partials.form', ['sessao' => $sessao])
    </div>
</div>