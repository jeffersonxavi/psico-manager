<!-- MODAL NOVO PACIENTE -->
<div id="pacienteModalOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div id="pacienteModalCard" class="bg-white w-full max-w-2xl rounded-xl shadow-2xl p-6 transform scale-95 opacity-0 transition-all">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Novo Paciente</h2>
            <button onclick="closePacienteModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <form id="formPaciente" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Nome Completo</label>
                    <input type="text" name="nome" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Nome do Paciente" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" class="w-full mt-1 border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Telefone</label>
                    <input type="tel" name="telefone" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="(99) 99999-9999">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">E-mail</label>
                    <input type="email" name="email" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="email@exemplo.com">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Contato de Emergência</label>
                    <input type="tel" name="contato_emergencia" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="(99) 99999-9999">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Estado Civil</label>
                    <select name="estado_civil" class="w-full mt-1 border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Viúvo(a)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Profissão</label>
                    <input type="text" name="profissao" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Profissão">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Endereço</label>
                    <input type="text" name="endereco" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Rua, número, bairro">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Histórico Médico / Observações</label>
                <textarea name="observacoes" class="w-full mt-1 border-gray-300 rounded-lg" rows="4" placeholder="Informações importantes sobre o paciente"></textarea>
            </div>

            <button type="button" id="btnSalvarPaciente" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow">
                Salvar Paciente
            </button>
        </form>
    </div>
</div>

<!-- MODAL AGENDAMENTO -->
<div id="modalOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden flex items-center justify-center z-50">
    <div id="modalCard" class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 transform scale-95 opacity-0 transition-all">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Novo Agendamento</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <form id="formAgendamento">
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Paciente</label>
                <select id="paciente_id" name="paciente_id" class="w-full mt-1 border-gray-300 rounded-lg">
                    <option value="">Selecione o paciente</option>
                    @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Título / Motivo</label>
                <input type="text" id="titulo" name="titulo" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Ex: Sessão de terapia" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Data</label>
                <input id="modalDate" name="data_hora_inicio" type="date" class="w-full mt-1 border-gray-300 rounded-lg" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Início</label>
                    <input id="modalStart" name="hora_inicio" type="time" class="w-full mt-1 border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Fim</label>
                    <input id="modalEnd" name="hora_fim" type="time" class="w-full mt-1 border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Observações</label>
                <textarea id="observacoes" name="observacoes" class="w-full mt-1 border-gray-300 rounded-lg" rows="3" placeholder="Informações adicionais"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Status</label>
                <select id="status" name="status" class="w-full mt-1 border-gray-300 rounded-lg text-gray-800">
                    <option value="agendado" selected class="text-gray-600">◉ Agendado</option>
                    <option value="confirmado" class="text-cyan-500">◉ Confirmado</option>
                    <option value="atendido" class="text-green-600">◉ Atendido</option>
                    <option value="faltou" class="text-yellow-500">◉ Faltou</option>
                    <option value="desmarcado" class="text-red-600">◉ Desmarcado</option>
                </select>
            </div>

            <button type="button" id="btnSalvarAgendamento" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow">
                Salvar Agendamento
            </button>
        </form>
    </div>
</div>