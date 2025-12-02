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

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // =============== ABRIR MODAL ===============
        window.openPacienteModal = function () {
            const overlay = document.getElementById('pacienteModalOverlay');
            const card = document.getElementById('pacienteModalCard');
            const form = document.getElementById('formPaciente');

            overlay.classList.remove('hidden');
            setTimeout(() => card.classList.remove('scale-95', 'opacity-0'), 10);

            document.getElementById('pacienteModalTitle').textContent = 'Cadastro de Novo Paciente';
            form.reset();
            document.getElementById('pacienteId').value = '';
        };

        // =============== FECHAR MODAL ===============
        window.closePacienteModal = function () {
            const overlay = document.getElementById('pacienteModalOverlay');
            const card = document.getElementById('pacienteModalCard');

            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        };

        // =============== EDITAR PACIENTE ===============
        window.editPaciente = function (id) {
            fetch(`/pacientes/${id}`)
                .then(res => {
                    if (!res.ok) throw new Error('Paciente não encontrado');
                    return res.json();
                })
                .then(paciente => {
                    openPacienteModal();
                    document.getElementById('pacienteModalTitle').textContent = 'Editar Paciente';

                    const form = document.getElementById('formPaciente');
                    form.nome.value = paciente.nome || '';
                    form.telefone.value = paciente.telefone || '';
                    form.email.value = paciente.email || '';
                    form.data_nascimento.value = paciente.data_nascimento || '';
                    form.contato_emergencia.value = paciente.contato_emergencia || '';
                    form.estado_civil.value = paciente.estado_civil || '';
                    form.profissao.value = paciente.profissao || '';
                    form.endereco.value = paciente.endereco || '';
                    form.observacoes.value = paciente.observacoes || '';

                    document.getElementById('pacienteId').value = paciente.id;
                })
                .catch(() => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Erro ao carregar paciente'
                    });
                });
        };

        // =============== DELETAR PACIENTE (se precisar no futuro) ===============
        window.deletePaciente = function (id, nome = 'este paciente') {
            Swal.fire({
                title: 'Tem certeza?',
                text: `O paciente "${nome}" será excluído permanentemente!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/pacientes/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            Swal.fire('Excluído!', res.message, 'success').then(() => location.reload());
                        } else {
                            Toast.fire({ icon: 'error', title: res.message || 'Erro ao excluir' });
                        }
                    })
                    .catch(() => Toast.fire({ icon: 'error', title: 'Erro de conexão' }));
                }
            });
        };

        // =============== SALVAR (CREATE / UPDATE) ===============
        document.getElementById('btnSalvarPaciente')?.addEventListener('click', function (e) {
            e.preventDefault();

            const form = document.getElementById('formPaciente');
            const formData = new FormData(form);
            const pacienteId = document.getElementById('pacienteId').value;

            // Sempre POST + updateOrCreate no backend (recomendado)
            fetch('{{ route("pacientes.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    closePacienteModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    let erro = 'Erro ao salvar.';
                    if (res.errors) {
                        erro = Object.values(res.errors).flat().join('<br>');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: erro
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Não foi possível conectar ao servidor.'
                });
            });
        });
    });
</script>
@endpush