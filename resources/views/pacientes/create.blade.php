<!-- MODAL PACIENTE -->
<div id="pacienteModalOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-[60] flex items-center justify-center transition-opacity duration-300 ease-out">
    <div id="pacienteModalCard" class="bg-white w-full max-w-2xl rounded-2xl shadow-3xl p-5 
            transform scale-95 opacity-0 transition-all duration-300 ease-out 
            border border-gray-100
            max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h2 id="pacienteModalTitle" class="text-2xl font-bold text-blue-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 18H5a2 2 0 01-2-2v-2c0-.518.261-1.002.7-1.31L7 11" />
                </svg>
                Cadastro de Paciente
            </h2>
            <button onclick="closePacienteModal()" class="text-gray-400 hover:text-red-500 text-2xl font-light p-1 transition">&times;</button>
        </div>

        <form id="formPaciente" class="space-y-6 text-sm">
            <input type="hidden" name="id" id="pacienteId">

            <!-- Campos do paciente -->
            <fieldset class="p-4 border border-gray-200 rounded-lg bg-slate-50/50">
                <legend class="text-base font-semibold text-gray-700 px-1">Informações Básicas</legend>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div class="lg:col-span-2">
                        <label class="block font-medium text-gray-700 mb-1">Nome Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Nascimento <span class="text-red-500">*</span></label>
                        <input type="date" name="data_nascimento" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm" required>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Telefone</label>
                        <input type="tel" name="telefone" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block font-medium text-gray-700 mb-1">E-mail</label>
                        <input type="email" name="email" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                    </div>
                </div>
            </fieldset>

            <fieldset class="p-4 border border-gray-200 rounded-lg">
                <legend class="text-base font-semibold text-gray-700 px-1">Outros Dados</legend>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Endereço</label>
                        <input type="text" name="endereco" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Profissão</label>
                        <input type="text" name="profissao" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Estado Civil</label>
                        <select name="estado_civil" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                            <option value="">Selecione</option>
                            <option value="solteiro">Solteiro(a)</option>
                            <option value="casado">Casado(a)</option>
                            <option value="divorciado">Divorciado(a)</option>
                            <option value="viuvo">Viúvo(a)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700 mb-1">Contato de Emergência</label>
                        <input type="tel" name="contato_emergencia" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm">
                    </div>
                </div>
            </fieldset>

            <div>
                <label class="block font-medium text-gray-700 mb-1">Observações</label>
                <textarea name="observacoes" rows="3" class="w-full border-gray-300 rounded-lg px-3 py-1.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition shadow-sm"></textarea>
            </div>

            <button type="button" id="btnSalvarPaciente" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold h-10 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Salvar
            </button>
        </form>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        // =============== FUNÇÕES GLOBAIS ===============
        window.openPacienteModal = function() {
            const overlay = document.getElementById('pacienteModalOverlay');
            const card = document.getElementById('pacienteModalCard');
            const form = document.getElementById('formPaciente');

            overlay.classList.remove('hidden');
            setTimeout(() => card.classList.remove('scale-95', 'opacity-0'), 10);

            document.getElementById('pacienteModalTitle').innerText = 'Cadastro de Novo Paciente';
            form.reset();
            document.getElementById('pacienteId').value = '';
        };

        window.closePacienteModal = function() {
            const overlay = document.getElementById('pacienteModalOverlay');
            const card = document.getElementById('pacienteModalCard');

            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        };

        window.editPaciente = function(id) {
            fetch(`/pacientes/${id}`)
                .then(res => {
                    if (!res.ok) throw new Error('Paciente não encontrado');
                    return res.json();
                })
                .then(paciente => {
                    openPacienteModal();
                    document.getElementById('pacienteModalTitle').innerText = 'Editar Paciente';

                    const form = document.getElementById('formPaciente');
                    form.nome.value = paciente.nome || '';
                    form.data_nascimento.value = paciente.data_nascimento || '';
                    form.telefone.value = paciente.telefone || '';
                    form.email.value = paciente.email || '';
                    form.endereco.value = paciente.endereco || '';
                    form.profissao.value = paciente.profissao || '';
                    form.estado_civil.value = paciente.estado_civil || '';
                    form.contato_emergencia.value = paciente.contato_emergencia || '';
                    form.observacoes.value = paciente.observacoes || '';

                    document.getElementById('pacienteId').value = paciente.id;
                })
                .catch(err => {
                    console.error(err);
                    alert('Erro ao carregar os dados do paciente.');
                });
        };

        // =============== DELEGAÇÃO DO CLIQUE EM "EDITAR" ===============
        document.addEventListener('click', function(e) {
            const link = e.target.closest('.editar-paciente');
            if (link) {
                e.preventDefault();
                const id = link.getAttribute('data-id');
                if (id) editPaciente(id);
            }
        });

        // =============== SALVAR (CREATE / UPDATE) ===============
        const btnSalvar = document.getElementById("btnSalvarPaciente");
        if (btnSalvar) {
            btnSalvar.addEventListener("click", function() {
                const form = document.getElementById("formPaciente");
                const formData = new FormData(form);
                const pacienteId = document.getElementById("pacienteId").value;

                let url = '/pacientes';
                let method = 'POST';

                if (pacienteId) {
                    url = `/pacientes/${pacienteId}`;
                    formData.append('_method', 'PUT');
                }

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            alert(res.message || 'Salvo com sucesso!');
                            closePacienteModal();
                            location.reload();
                        } else {
                            let erro = 'Erro ao salvar.';
                            if (res.errors) {
                                erro = Object.values(res.errors).flat().join('\n');
                            }
                            alert(erro);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Erro de conexão.');
                    });
            });
        }
    });
</script>