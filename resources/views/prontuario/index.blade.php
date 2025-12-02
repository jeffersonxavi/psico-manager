@extends('layouts.app')
@section('title', 'Prontuário • ' . $paciente->nome)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50/30 via-white to-indigo-50/20">
    <div class="mx-auto px-6 py-10"
         x-data="prontuarioApp({{ session()->pull('abrir_modal_sessao') ? 'true' : 'false' }})">

        <div class="text-center sm:text-left">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Prontuário de <span class="text-blue-700">{{ $paciente->nome }}</span>
            </h1>
            <p class="text-lg text-gray-600 mt-3">
                <span class="font-semibold text-blue-700">{{ $sessoes->count() }}</span>
                {{ Str::plural('sessão registrada', $sessoes->count()) }}
            </p>
        </div>

        <div class="flex justify-center sm:justify-end mb-10">
            <button @click="novaSessao()"
                class="group inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-9 py-5 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-lg">
                <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Sessão
            </button>
        </div>
        <div id="lista-sessoes" x-cloak>
            @forelse($sessoes as $sessao)
                {{-- 1. O contêiner de colunas DEVE envolver TODOS os itens quando eles existirem. --}}
                @if ($loop->first)
                    <div class="columns-1 sm:columns-2 xl:columns-3 space-y-8 gap-8">
                @endif

                    {{-- O item individual (card) deve ter 'break-inside-avoid' --}}
                    <div 
                        class="break-inside-avoid mb-8" 
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-12 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    >
            {{-- CÓDIGO CORRIGIDO DO LOOP PRINCIPAL --}}
        <div class="break-inside-avoid mb-8">
            {{-- Card da sessão (o padding interno será tratado dentro do 'sessao-item') --}}
            <div>
                @include('sessoes.sessao-item', compact('sessao', 'paciente'))
            </div>
            </div>
                        
                        {{-- O overlay de hover não precisa do 'absolute inset-0' aqui 
                            a menos que a div 'break-inside-avoid' tenha 'relative' --}}
                        </div>

                {{-- 2. Fechar o contêiner de colunas no final do loop --}}
                @if ($loop->last)
                    </div>
                @endif

            @empty
                {{-- Bloco @empty: Centralizado e com largura total (W-FULL) --}}
                <div class="w-full flex justify-center py-16">
                    <div class="max-w-xl text-center p-10 bg-white/80 backdrop-blur-sm rounded-3xl border border-gray-200 shadow-xl">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6-4h6m-6 8h6m-9 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Nenhuma sessão registrada</h3>
                        <p class="text-gray-600 mb-8">Comece registrando o primeiro atendimento deste paciente.</p>
                        <button @click="novaSessao()"
                            class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            Criar primeira sessão
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
        @include('sessoes.modal-create')

        <div 
            x-show="loading"
            x-transition.opacity
            class="fixed inset-0 bg-black/40 backdrop-blur-sm
                   flex items-center justify-center z-[100]"
            style="display: none;" {{-- Esconde inicialmente para evitar flash --}}
        >
            <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center gap-3">
                <svg class="animate-spin h-8 w-8 text-blue-600" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                </svg>
                <span class="text-gray-700 font-semibold text-lg">Processando...</span>
                <span class="text-gray-500 text-sm">Aguarde um momento, por favor.</span>
            </div>
        </div>
        {{-- FIM NOVO: MODAL LOADING --}}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>

<script>
    // Função global para usar em qualquer lugar (Livewire, Alpine, etc)
    window.swalFire = function({title = '', text = '', icon = 'success', timer = 3000, showConfirmButton = false} = {}) {
        // ... (código SweetAlert inalterado)
        return Swal.fire({
            icon,
            title,
            text,
            timer,
            timerProgressBar: true,
            showConfirmButton: showConfirmButton,
            allowOutsideClick: false,
            customClass: {
                popup: 'animated fadeInDown faster',
                confirmButton: 'btn bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl'
            },
            buttonsStyling: false
        });
    };

    // Mensagens automáticas do Laravel (success, error, warning, info)
    document.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            swalFire({
                icon: 'success',
                title: 'Tudo certo!',
                text: "{{ session('success') }}",
                timer: 1000,
                showConfirmButton: false
            });
        @endif
        // ... (outros ifs de session inalterados)
        @if(session('error'))
            swalFire({
                icon: 'error',
                title: 'Ocorreu um erro',
                text: "{{ session('error') }}",
                timer: 2000,
                showConfirmButton: true
            });
        @endif

        @if(session('warning'))
            swalFire({
                icon: 'warning',
                title: 'Atenção',
                text: "{{ session('warning') }}",
                timer: 2000,
                showConfirmButton: true
            });
        @endif

        @if(session('info'))
            swalFire({
                icon: 'info',
                title: 'Informação',
                text: "{{ session('info') }}",
                timer: 1000
            });
        @endif
    });

    // NOVO: Funções de App e Funções de Loading para formulários CRUD
    function prontuarioApp(autoOpen = false) {
        return {
            loading: false, // NOVO: Estado de carregamento
            modalAberto: autoOpen,
            editando: false,
            idSessao: null,
            consultaId: {{ session('consulta_id') ? 'true' : 'false' }},

            dataSessao: '',
            conteudoSessao: '',
            
            // ... (Getters, novaSessao e editarSessao inalterados)

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
                if (!form) return; // Garante que o formulário existe

                // LIGA O EVENTO DE SUBMISSÃO AO LOADING AQUI
                form.onsubmit = () => {
                    this.modalAberto = false; // Fecha o modal de criação/edição
                    this.loading = true; // Ativa o modal de loading
                    return true; // Permite a submissão real do formulário
                };
                
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
            },

            confirmarExclusao(id, nomePaciente) {
                // ... (lógica de exclusão inalterada)
                Swal.fire({
                    title: 'Excluir sessão?',
                    text: `Esta ação não pode ser desfeita.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, excluir',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-xl ml-3',
                        cancelButton: 'btn bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-xl'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // NOVO: Ativa o loading na exclusão também
                        this.loading = true;
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            }
        }
    }
</script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection