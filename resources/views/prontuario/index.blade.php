@extends('layouts.app')
@section('title', 'Prontuário • ' . $paciente->nome)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50/30 via-white to-indigo-50/20">
    <div class="mx-auto px-6 py-10"
         x-data="sessaoModal({{ session()->pull('abrir_modal_sessao') ? 'true' : 'false' }})">

        <!-- Cabeçalho -->
        <div class="mb-12 text-center sm:text-left">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Prontuário de <span class="text-blue-700">{{ $paciente->nome }}</span>
            </h1>
            <p class="text-lg text-gray-600 mt-3">
                <span class="font-semibold text-blue-700">{{ $sessoes->count() }}</span>
                {{ Str::plural('sessão registrada', $sessoes->count()) }}
            </p>
        </div>

        <!-- Botão Nova Sessão -->
        <div class="flex justify-center sm:justify-end mb-10">
            <button @click="novaSessao()"
                class="group inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-9 py-5 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-lg">
                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Sessão
            </button>
        </div>

        <!-- Toast de Feedback (substitui os alerts antigos) -->
        <div x-show="!!$store.toast.mensagem" 
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="transform translate-y-8 opacity-0"
             x-transition:enter-end="transform translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-end="transform -translate-y-8 opacity-0"
             class="fixed top-6 right-6 z-50 max-w-md">
            <div class="bg-white rounded-2xl shadow-2xl border-l-4 overflow-hidden"
                 :class="$store.toast.tipo === 'success' ? 'border-green-500' : 'border-amber-500'">
                <div class="p-6 flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg x-show="$store.toast.tipo === 'success'" class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <svg x-show="$store.toast.tipo === 'warning'" class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.366-.447.897-.447 1.263 0l6.18 7.554a.75.75 0 01-.579 1.214H3.858a.75.75 0 01-.579-1.214l6.18-7.554zM10 15a1 1 0 100-2 1 1 0 000 2zm0-8v4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900" x-text="$store.toast.titulo"></p>
                        <p class="text-sm text-gray-600 mt-1" x-text="$store.toast.mensagem"></p>
                    </div>
                    <button @click="$store.toast.mensagem = null" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Lista de Sessões -->
        <div id="lista-sessoes" class="space-y-10">
            @forelse($sessoes as $sessao)
                <div x-transition:enter="transition ease-out duration-600"
                     x-transition:enter-start="opacity-0 translate-y-10 scale-98"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                    @include('sessoes.sessao-item', compact('sessao', 'paciente'))
                </div>
            @empty
                <div class="text-center py-32 bg-white/80 backdrop-blur-sm rounded-3xl border-2 border-dashed border-gray-300">
                    <div class="max-w-md mx-auto">
                        <div class="w-28 h-28 mx-auto mb-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-14 h-14 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6-4h6m-6 8h6m-9 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Nenhuma sessão registrada</h3>
                        <p class="text-gray-600 text-lg mb-10">Comece agora registrando o primeiro atendimento deste paciente.</p>
                        <button @click="novaSessao()"
                            class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            Criar primeira sessão
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Modal (agora mais bonito, mas com a mesma lógica) -->
        @include('sessoes.modal-create')
    </div>
</div>

<!-- Toast Store + Alpine -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('toast', {
            mensagem: null,
            tipo: 'success',
            titulo: '',
            mostrar(mensagem, tipo = 'success', titulo = 'Sucesso') {
                this.mensagem = mensagem;
                this.tipo = tipo;
                this.titulo = titulo;
                setTimeout(() => this.mensagem = null, 6000);
            }
        });

        // Mostra mensagens do Laravel automaticamente
        @if(session('success'))
            Alpine.store('toast').mostrar("{{ session('success') }}", 'success', 'Tudo certo!');
        @endif
        @if(session('warning'))
            Alpine.store('toast').mostrar("{{ session('warning') }}", 'warning', 'Atenção');
        @endif
    });

    // Sua função original 100% preservada (só com pequenos ajustes visuais no modal)
    function sessaoModal(autoOpen = false) {
        return {
            modalAberto: autoOpen,
            editando: false,
            idSessao: null,
            consultaId: {{ session('consulta_id') ? 'true' : 'false' }},

            dataSessao: '',
            conteudoSessao: '',

            get tituloModal() {
                if (this.editando) return 'Editar Sessão';
                if (this.consultaId) return 'Atendimento da Consulta';
                return 'Nova Sessão Avulsa';
            },

            get textoBotao() {
                return this.editando ? 'Salvar Alterações' : 'Salvar Sessão';
            },

            novaSessao() {
                this.editando = false;
                this.idSessao = null;
                this.consultaId = {{ session('consulta_id') ? 'true' : 'false' }};
                this.dataSessao = '{{ now()->format('Y-m-d\TH:i') }}';
                this.conteudoSessao = '';
                this.modalAberto = true;
                this.$nextTick(() => this.preencherCampos());
            },

            editarSessao(sessao) {
                this.editando = true;
                this.idSessao = sessao.id;
                this.consultaId = false;
                this.dataSessao = sessao.data_sessao;
                this.conteudoSessao = sessao.conteudo || '';
                this.modalAberto = true;
                this.$nextTick(() => this.preencherCampos());
            },

            preencherCampos() {
                const form = document.getElementById('form-sessao');
                if (this.editando) {
                    form.action = `/sessoes/${this.idSessao}`;
                    if (!form.querySelector("input[name='_method']")) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = '_method';
                        input.value = 'PUT';
                        form.prepend(input);
                    }
                } else {
                    form.action = "{{ route('sessoes.store', $paciente) }}";
                    form.querySelector("input[name='_method']")?.remove();
                }

                const inputData = form.querySelector("input[name='data_sessao']");
                const textarea = form.querySelector("textarea[name='conteudo']");
                if (inputData) inputData.value = this.dataSessao;
                if (textarea) textarea.value = this.conteudoSessao;
            }
        }
    }
</script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection