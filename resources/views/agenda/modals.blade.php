<!-- MODAL NOVO PACIENTE -->
<div id="pacienteModalOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-[60] flex items-center justify-center transition-opacity duration-300 ease-out">
    <div id="pacienteModalCard" class="bg-white w-full max-w-4xl rounded-2xl shadow-3xl p-10 transform scale-95 opacity-0 transition-all duration-300 ease-out border border-gray-100">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-3xl font-extrabold text-blue-700 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 18H5a2 2 0 01-2-2v-2c0-.518.261-1.002.7-1.31L7 11" />
                </svg>
                Cadastro de Novo Paciente
            </h2>
            <button onclick="closePacienteModal()" class="text-gray-400 hover:text-red-500 text-3xl font-light p-1 transition">
                &times;
            </button>
        </div>

        <form id="formPaciente" class="space-y-8">

            <fieldset class="p-5 border border-gray-200 rounded-xl bg-slate-50/50">
                <legend class="text-lg font-bold text-gray-700 px-2">Informações Básicas</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nome Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" placeholder="Nome completo do paciente" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Data de Nascimento <span class="text-red-500">*</span></label>
                        <input type="date" name="data_nascimento" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Telefone</label>
                        <input type="tel" name="telefone" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" placeholder="(99) 99999-9999">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">E-mail</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" placeholder="email@exemplo.com">
                    </div>

                </div>
            </fieldset>

            <fieldset class="p-5 border border-gray-200 rounded-xl">
                <legend class="text-lg font-bold text-gray-700 px-2">Outros Dados</legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Endereço Completo</label>
                        <input type="text" name="endereco" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" placeholder="Rua, número, bairro, cidade - UF">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Profissão</label>
                        <input type="text" name="profissao" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" placeholder="Ocupação atual">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Estado Civil</label>
                        <select name="estado_civil" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                            <option value="">Selecione</option>
                            <option value="solteiro">Solteiro(a)</option>
                            <option value="casado">Casado(a)</option>
                            <option value="divorciado">Divorciado(a)</option>
                            <option value="viuvo">Viúvo(a)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Contato de Emergência</label>
                        <input type="tel" name="contato_emergencia" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" placeholder="(99) 99999-9999">
                    </div>

                </div>
            </fieldset>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Histórico Médico / Observações</label>
                <textarea name="observacoes" class="w-full border-gray-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" rows="4" placeholder="Alergias, medicamentos, histórico relevante, metas de tratamento, etc."></textarea>
            </div>

            <button type="button" id="btnSalvarPaciente" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transition duration-200 flex items-center justify-center gap-2 mt-8 text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3h2m0-1v-6a2 2 0 012-2h4a2 2 0 012 2v6m-4-6V7a2 2 0 00-2-2H9a2 2 0 00-2 2v4m3 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
                Salvar Cadastro
            </button>
        </form>
    </div>
</div>
<!-- MODAL AGENDAMENTO -->
<div id="modalOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center z-[60] transition-opacity duration-300 ease-out">
    <div id="modalCard" class="bg-white w-full max-w-md rounded-2xl shadow-3xl p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out border border-gray-100">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 id="modalTitle" class="text-3xl font-extrabold text-blue-700 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-4 4V3m-2 4h4M6 11h12M6 15h12M6 19h12M4 4h16a2 2 0 012 2v14a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>
                Detalhes do Agendamento
            </h2>
            <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-3xl font-light p-1 transition">
                &times;
            </button>
        </div>

        <form id="formAgendamento" class="space-y-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Paciente <span class="text-red-500">*</span></label>
                    <select id="paciente_id" name="paciente_id" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                        <option value="">Selecione o paciente</option>
                        @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Título / Motivo <span class="text-red-500">*</span></label>
                    <input type="text" id="titulo" name="titulo" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" placeholder="Ex: Sessão de terapia, Consulta de rotina" required>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 p-4 bg-blue-50 rounded-xl border border-blue-200/50">
                <div>
                    <label class="block text-xs font-bold text-blue-800 mb-1">Data</label>
                    <input id="modalDate" name="data_hora_inicio" type="date" class="w-full border-blue-300 rounded-lg px-2 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition shadow-sm text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-blue-800 mb-1">Início</label>
                    <input id="modalStart" name="hora_inicio" type="time" class="w-full border-blue-300 rounded-lg px-2 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition shadow-sm text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-blue-800 mb-1">Fim</label>
                    <input id="modalEnd" name="hora_fim" type="time" class="w-full border-blue-300 rounded-lg px-2 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition shadow-sm text-sm" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Observações</label>
                <textarea id="observacoes" name="observacoes" class="w-full border-gray-300 rounded-xl px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" rows="3" placeholder="Informações adicionais importantes para a consulta"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="w-full border-gray-300 rounded-xl px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm text-gray-800 font-medium">
                    <option value="agendado" selected class="text-gray-600">🗓️ Agendado (Aguardando)</option>
                    <option value="confirmado" class="text-green-600 font-medium">✅ Confirmado</option>
                    <option value="atendido" class="text-blue-600 font-medium">🤝 Atendido / Concluído</option>
                    <option value="faltou" class="text-yellow-600 font-medium">⚠️ Faltou / Não Compareceu</option>
                    <option value="desmarcado" class="text-red-600 font-medium">❌ Desmarcado / Cancelado</option>
                </select>
            </div>

            <div class="flex justify-between items-center pt-5 border-t mt-6">
                <button type="button" id="btnExcluirAgendamento"
                    class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-4 h-11 rounded-xl shadow-lg hover:shadow-xl transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                    </svg>
                    Excluir
                </button>

                <button type="button" id="btnSalvarAgendamento"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold h-11 rounded-xl shadow-lg hover:shadow-xl transition text-center ml-4 flex items-center justify-center gap-2 text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Salvar Alterações
                </button>
            </div>

        </form>
    </div>
</div>