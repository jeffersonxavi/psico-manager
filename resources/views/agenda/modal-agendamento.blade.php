<div>

    <!-- <div
        id="loadingOverlay"
        class="fixed inset-0 bg-black/40 backdrop-blur-sm
               flex items-center justify-center z-[100] hidden"
    >
        <div class="bg-white p-6 rounded-2xl shadow-2xl flex flex-col items-center gap-3">
            <svg class="animate-spin h-8 w-8 text-blue-600" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <span class="text-gray-700 font-semibold text-lg">Processando...</span>
            <span class="text-gray-500 text-sm">Aguarde um momento, por favor.</span>
        </div>
    </div> -->
    <div id="modalOverlay"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden flex items-center justify-center z-[60] transition-opacity duration-200">

        <div id="modalCard"
             class="bg-white w-full max-w-sm rounded-2xl shadow-xl p-4
                    border border-gray-200 transform scale-95 opacity-0 transition-all duration-200
                    max-h-[85vh] overflow-y-auto">

            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 id="modalTitle"
                    class="text-xl font-semibold text-blue-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-4 4V3m-2 4h4M6 11h12M6 15h12M6 19h12M4 4h16a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z" />
                    </svg>
                    Agendamento
                </h2>

                <button onclick="closeModal()"
                        class="text-gray-400 hover:text-red-500 text-xl transition leading-none">
                    &times;
                </button>
            </div>

            <form id="formAgendamento" class="space-y-4">

                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-700">
                        Paciente <span class="text-red-500">*</span>
                    </label>
                    <select id="paciente_id" name="paciente_id"
                        class="w-full border-gray-300 rounded-lg px-2 py-1.5 text-sm
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                        <option value="">Selecione o paciente</option>
                        @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-700">
                        Título / Motivo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="titulo" name="titulo"
                           class="w-full border-gray-300 rounded-lg px-2 py-1.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                           placeholder="Ex: Sessão de terapia" required>
                </div>

                <div class="grid grid-cols-3 gap-2 p-2 bg-blue-50 rounded-lg border border-blue-200">
                    <div>
                        <label class="block text-[11px] font-semibold text-blue-800 mb-1">Data</label>
                        <input id="modalDate" type="date" name="data_hora_inicio"
                               class="w-full border-blue-300 rounded-lg px-2 py-1 text-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-300" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-blue-800 mb-1">Início</label>
                        <input id="modalStart" type="time" name="hora_inicio"
                               class="w-full border-blue-300 rounded-lg px-2 py-1 text-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-300" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-blue-800 mb-1">Fim</label>
                        <input id="modalEnd" type="time" name="hora_fim"
                               class="w-full border-blue-300 rounded-lg px-2 py-1 text-sm
                                      focus:border-blue-500 focus:ring-2 focus:ring-blue-300" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-700">Observações</label>
                    <textarea id="observacoes" name="observacoes"
                        class="w-full border-gray-300 rounded-lg px-2 py-1.5 text-sm
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                        rows="2"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1 text-gray-700">Status</label>
                    <select id="status" name="status"
                        class="w-full border-gray-300 rounded-lg px-2 py-1.5 text-sm
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        <option value="agendado">🗓️ Agendado</option>
                        <option value="confirmado">🤝 Confirmado</option>
                        <option value="atendido">✅ Atendido</option>
                        <option value="faltou">⚠️ Faltou</option>
                        <option value="desmarcado">❌ Desmarcado</option>
                    </select>
                </div>


                <div class="flex justify-between items-center pt-3 border-t">

                    <button type="button" id="btnExcluirAgendamento"
                        class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white
                               text-sm font-medium px-3 h-9 rounded-lg shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                        </svg>
                        Excluir
                    </button>

                    <button type="submit" id="btnSalvarAgendamento"
                        class="flex-1 ml-3 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white
                               text-sm font-semibold h-9 rounded-lg shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Salvar
                    </button>
                </div>

                <button type="button" id="btnIniciarAtendimento"
                    class="hidden w-full mt-2 flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white
                           text-sm font-medium h-9 rounded-lg shadow transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 10l-2 1m0 0l-2-1m2 1v2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Iniciar Atendimento
                </button>

            </form>
        </div>
    </div>
</div>
<script>
    const form = document.getElementById('formAgendamento');
    const loadingOverlay = document.getElementById('loadingOverlay'); 
    const modalOverlay = document.getElementById('modalOverlay'); 

    // Assumindo que a função closeModal() existe e tem uma transição de ~150ms

    // NOVO: Função que lida com o envio do formulário
    form.addEventListener('submit', function(event) {
        event.preventDefault(); 

        // 1. Mostrar o Loading
        if (loadingOverlay) {
            loadingOverlay.classList.remove('hidden');
        }

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // SIMULAÇÃO DE ATRASO (Representando a requisição HTTP real)
        setTimeout(() => {
            console.log('Agendamento salvo com sucesso (simulado)!');
            
            // 2. Primeiro, ESCONDE o Loading e INICIA a transição do modal principal
            if (loadingOverlay) {
                loadingOverlay.classList.add('hidden');
            }
            closeModal(); 
            
            // 3. SweetAlert de Sucesso (Executa após o modal principal fechar)
            // O tempo de 200ms garante que a transição de fechamento do closeModal() (cerca de 150ms) termine.
            setTimeout(() => {
                /* Swal.fire({
                    icon: 'success',
                    title: 'Agendamento Salvo!', 
                        timer: 2000,
                    showConfirmButton: false
                }); */

                // Opcional: Recarregar o calendário (Se estiver integrando o FullCalendar)
                // if (typeof calendar !== 'undefined' && calendar.refetchEvents) {
                //     calendar.refetchEvents();
                // }
                
            }, 200); // <-- Novo timeout para o SweetAlert

        }, 0); // <-- Tempo de simulação da requisição reduzido para 500ms (mais realista)
    });
</script>