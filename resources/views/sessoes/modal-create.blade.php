<style>
    /* Boa Prática: Ocultar o conteúdo antes do Alpine carregar */
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-show="modalAberto" x-transition
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
     @keydown.escape.window="modalAberto = false"
     x-cloak
     role="dialog"
     aria-modal="true"
     aria-labelledby="modal-titulo-sessao"> 
    
    <div @click.away="modalAberto = false"
         class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden transform transition-all duration-300">

        <div class="{{ session('consulta_id') ? 'bg-gradient-to-r from-emerald-500 to-teal-600' : 'bg-gray-800' }} text-white p-5 flex justify-between items-start flex-shrink-0">
            <div>
                <h2 class="text-xl font-bold flex items-center gap-3" x-text="tituloModal" id="modal-titulo-sessao"></h2> 
                <p class="text-white/90 text-lg font-medium">{{ $paciente->nome }}</p>
                @if(session('consulta_id'))
                    <span class="inline-flex items-center gap-1 mt-2 text-sm bg-white/25 px-3 py-1 rounded-full font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Consulta será marcada como atendida
                    </span>
                @endif
            </div>
            <button @click="modalAberto = false" 
                    class="text-white/80 hover:text-white transition-colors"
                    aria-label="Fechar Modal">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="form-sessao" 
              action="{{ route('sessoes.store', $paciente) }}" 
              method="POST" 
              class="flex-1 overflow-y-auto p-6 space-y-6">

            @csrf
            <input type="hidden" name="consulta_id" value="{{ old('consulta_id', session('consulta_id')) }}">

            <div>
                <label for="data_sessao" class="block text-sm font-semibold text-gray-800 mb-2">
                    Data e Hora da Sessão
                    @if(session('consulta_id'))
                        <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-1 rounded ml-2 font-medium">Pré-preenchida</span>
                    @endif
                </label>
                <input type="datetime-local" name="data_sessao" id="data_sessao" required
                       value="{{ old('data_sessao', session('data_sessao') ?? now()->format('Y-m-d\TH:i')) }}"
                       class="w-full px-4 py-3 rounded-lg border-2 {{ session('consulta_id') ? 'border-emerald-300 bg-emerald-50' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition appearance-none">
            </div>

            <div>
                <label for="conteudo" class="block text-sm font-semibold text-gray-800 mb-2">Relato da Sessão</label>
                <textarea name="conteudo" id="conteudo" rows="10" required 
                          placeholder="{{ session('consulta_id') ? 'Paciente chegou para a consulta agendada...' : 'Descreva o que aconteceu na sessão...' }}"
                          class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition resize-none"></textarea>
            </div>
            
            <div class="border-t border-gray-200 bg-gray-50 -mx-6 mt-6 px-6 py-5 flex-shrink-0">
                <div class="flex justify-between items-center gap-4">
                    <div class="text-sm">
                        @if(session('consulta_id'))
                            <span class="text-emerald-600 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Consulta será finalizada ao salvar
                            </span>
                        @else
                            <span class="text-gray-500">Sessão avulsa</span>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="modalAberto = false"
                                class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-lg shadow-blue-500/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            <span x-text="textoBotao"></span>
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>