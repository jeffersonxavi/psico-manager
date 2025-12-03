<div
    x-data="{ showForm: false }" {{-- 👈 Novo: Gerencia a visibilidade do formulário --}}
    class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl group">

    {{-- ## Header da Sessão (Informações e Ações da Sessão) --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">

            {{-- Informações da Sessão --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 flex-wrap">
                <div class="flex items-center gap-3">
                    {{-- Indicador de status/atualização --}}
                    <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>

                    {{-- Título da Sessão (MODIFICADO AQUI!) --}}
                    <h3 class="text-md font-extrabold text-gray-800">
                        {{ $loop->count - $loop->index }}ª Sessão • {{ $sessao->data_sessao->format('d/m/Y \à\s H:i') }}
                    </h3>
                </div>

                {{-- Nome do Profissional --}}
                <span
                    class="text-xs text-gray-600 bg-white/70 px-3 py-1 rounded-full font-semibold shadow-sm whitespace-nowrap">
                    por {{ $sessao->profissional->name }}
                </span>
            </div>

            {{-- ## Ações da Sessão (Botões) --}}
            <div class="flex items-center gap-2 flex-shrink-0">

                {{-- Botão Editar/Detalhes da Sessão --}}
                <button @click="editarSessao({
                    id: {{ $sessao->id }},
                    data_sessao: '{{ $sessao->data_sessao->format('Y-m-d\TH:i') }}',
                    conteudo: @js($sessao->conteudo)
                })"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl hover:bg-blue-100 hover:border-blue-400 transition-all text-sm font-semibold shadow-sm">
                    {{-- Ícone de Detalhes --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="hidden sm:inline">Detalhes</span>
                </button>

                {{-- Botão Excluir Sessão --}}
                <form method="POST" action="{{ route('sessoes.destroy', $sessao->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Tem certeza que deseja excluir esta sessão?')"
                        class="p-2 text-red-600 hover:bg-red-100 rounded-xl transition-all">
                        {{-- Ícone de Lixeira --}}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2.375 2.375 0 0116.138 21H7.862a2.375 2.375 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ## Conteúdo da sessão (Relato Principal) --}}
    @if($sessao->conteudo)
       <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                {!! $sessao->conteudo ?? '<em class="text-gray-500">Nenhum relato registrado.</em>' !!}
            </div>
        </div>
    @endif

    {{-- ## Lista de registros (Clean e Compacta) --}}
    <div class="px-5 py-3 space-y-2">

        <h4 class="text-xs font-bold text-gray-500 uppercase pb-1 mb-1 border-b border-gray-100">
            Registros de Acompanhamento
        </h4>

        @if($sessao->registros->count())
            <div class="space-y-1"> {{-- Espaçamento mais compacto entre os itens --}}
                @foreach($sessao->registros as $registro)
                    {{-- Usando 'registro-item' conforme solicitado (Idealmente deveria ser 'registro-item-clean') --}}
                    @include('registros.partials.registro-item', compact('registro', 'sessao'))
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-400 italic py-2 text-xs">
                Nenhum registro de acompanhamento após esta sessão.
            </p>
        @endif
    </div>

    {{-- ------------------------------------------------------------------------------------------------ --}}
    
    {{-- ## BOTÃO / FORMULÁRIO (Condicional - Alpine.js) --}}
    <div class="border-t border-gray-200">
        {{-- 1. Botão Adicionar (Mostrado se showForm for falso) --}}
        <div x-show="!showForm" class="p-3 text-center">
            <button @click="showForm = true"
                    class="w-full py-2 px-4 rounded-xl bg-gray-50 text-gray-600 hover:bg-gray-100 transition duration-300 font-semibold text-sm flex items-center justify-center gap-2 border border-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Adicionar Novo Registro
            </button>
        </div>

        {{-- 2. Formulário (Mostrado se showForm for verdadeiro) --}}
        <div x-show="showForm" x-transition:enter.duration.300ms
             class="bg-gray-50/50">
            {{-- Inclui o Formulário de Registro --}}
            @include('registros.partials.form', ['sessao' => $sessao])
        </div>
    </div>
</div>