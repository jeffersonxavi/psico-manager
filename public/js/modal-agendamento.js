/* ---------------- MODAL DE AGENDAMENTO (Refatorado com SweetAlert2) ---------------- */

const modal = document.getElementById("modalOverlay");
const modalCard = document.getElementById("modalCard");

// FUNÇÃO DE LIMPEZA TOTAL (sem alterações)
function resetarModal() {
    const form = document.getElementById("formAgendamento");
    if (form) form.reset();
// Esconde todos os botões de ação específicos
    const botoesEspecificos = [
        "btnExcluirAgendamento",
        "btnIniciarAtendimento",
        "btnVisualizarAtendimento",
        "btnVerTodasSessoes"
    ];
    botoesEspecificos.forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.classList.add("hidden");
    });
    // Limpa campos manuais
    document.getElementById("paciente_id").value = "";
    document.getElementById("titulo").value = "";
    document.getElementById("status").value = "agendado";
    document.getElementById("modalDate").value = "";
    document.getElementById("modalStart").value = "";
    document.getElementById("modalEnd").value = "";
    document.getElementById("observacoes").value = ""; // Adicionado 'observacoes' aqui
    
    // Botões
    document.getElementById("btnExcluirAgendamento").classList.add("hidden");
    document.getElementById("btnIniciarAtendimento").classList.add("hidden"); // Esconder ao resetar
    document.getElementById("btnSalvarAgendamento").onclick = null;
    document.getElementById("btnExcluirAgendamento").onclick = null;
    document.getElementById("btnIniciarAtendimento").onclick = null;
}
// ------------------- FUNÇÃO AUXILIAR PARA CONFIGURAR STATUS -------------------
/**
 * Ajusta o campo de status do agendamento.
 * - Se o status for "atendido", desabilita o select para impedir alterações.
 * - Em novos agendamentos, impede que o usuário selecione "atendido" manualmente.
 * @param {HTMLSelectElement} selectStatus - O campo <select> de status
 * @param {string} statusAtual - Status atual do agendamento
 */
function configurarStatus(selectStatus, statusAtual) {
    // Se já estiver atendido OU faltou → trava o select
    selectStatus.disabled = ["atendido", "faltou"].includes(statusAtual);

    // Desabilita opção "atendido" em novos agendamentos
    const optionAtendido = selectStatus.querySelector("option[value='atendido']");
    if (optionAtendido && statusAtual !== "atendido") {
        optionAtendido.disabled = true;
    }

    // Desabilita opção "faltou" se já estiver faltou (evita mexer)
    const optionFaltou = selectStatus.querySelector("option[value='faltou']");
    if (optionFaltou && statusAtual === "faltou") {
        optionFaltou.disabled = true;
    }
}


// ------------------- ABRIR MODAL DE NOVO AGENDAMENTO -------------------
/**
 * Abre o modal para criar um novo agendamento.
 * Preenche data, hora e status padrão.
 * @param {Object} info - Informações do calendário (start e end)
 */
window.openModalAgendamento = function(info) {
    showModal();      // Mostra o modal
    resetarModal();   // Limpa todos os campos

    document.getElementById("modalTitle").innerText = "Novo Agendamento";

    const start = moment(info.start); 
    const end = moment(info.end || start.clone().add(30, "minutes")); // Duração padrão: 30 min

    // Preenche campos de data e hora
    document.getElementById("modalDate").value = start.format("YYYY-MM-DD");
    document.getElementById("modalStart").value = start.format("HH:mm");
    document.getElementById("modalEnd").value = end.format("HH:mm");

    // Define status padrão e aplica regras
    const selectStatus = document.getElementById("status");
    selectStatus.value = "agendado";
    configurarStatus(selectStatus, "agendado");

    // Define ação do botão Salvar
    document.getElementById("btnSalvarAgendamento").onclick = salvarAgendamento;

    // Esconde o botão "Ver todas as sessões" para novos agendamentos
    document.getElementById("btnVerTodasSessoes").classList.add("hidden");
    document.getElementById("btnIniciarAtendimento").classList.add("hidden");
};

// ------------------- ABRIR MODAL DE EDIÇÃO DE AGENDAMENTO -------------------
/**
 * Abre o modal para editar um agendamento existente.
 * Preenche todos os campos com os dados do evento selecionado.
 * @param {Object} info - Evento do calendário
 */
// Função que abre o modal de edição de agendamento
window.openModalEdicao = function(info) {
    // Mostra o modal e limpa campos
    showModal();
    resetarModal();

    const event = info.event;
    const id = String(event.id);

    document.getElementById("modalTitle").innerText = "Editar Agendamento";

    // Preenche campos com dados do evento
    document.getElementById("paciente_id").value = event.extendedProps.paciente_id || "";
    document.getElementById("titulo").value = event.extendedProps.titulo ?? event.title?.split(" - ").at(-1)?.trim() ?? "";
    const status = event.extendedProps.status || "agendado";
    document.getElementById("status").value = status;
    document.getElementById("observacoes").value = event.extendedProps.observacoes ?? "";

    const inicio = moment.parseZone(event.start).local();
    const fim = event.end
        ? moment.parseZone(event.end).local()
        : inicio.clone().add(50, "minutes");

    // Data e hora no modal
    document.getElementById("modalDate").value = inicio.format("YYYY-MM-DD");
    document.getElementById("modalStart").value = inicio.format("HH:mm");
    document.getElementById("modalEnd").value = fim.format("HH:mm");

    // Aplica regras de exibição do status (função externa)
    configurarStatus(document.getElementById("status"), status);

    // Botão Salvar → chama função updateAgendamento()
    document.getElementById("btnSalvarAgendamento").onclick = () => updateAgendamento(id);

    // Botão Excluir → mostra e conecta à função excluirAgendamento()
    const btnExcluir = document.getElementById("btnExcluirAgendamento");
    btnExcluir.classList.remove("hidden");
    btnExcluir.onclick = () => excluirAgendamento(id);

    // ------ Regras do botão "Iniciar Atendimento" ------
    // ------ Regras do botão "Iniciar Atendimento" ------
    const btnIniciar = document.getElementById("btnIniciarAtendimento");
    const hoje = moment().startOf("day");
    const diaConsulta = inicio.clone().startOf("day");
    const temPaciente = !!event.extendedProps.paciente_id;
    const statusAtual = status;

    // Nova variável: verifica se já existe sessão registrada
    const temSessaoRegistrada = !!event.extendedProps.sessao_id; // ajuste conforme seu backend

    // Condição para MOSTRAR o botão "Iniciar Atendimento"
    const podeIniciarAtendimento =
        temPaciente &&
        ["agendado", "confirmado", "faltou"].includes(statusAtual) &&
        !temSessaoRegistrada &&                     // ← chave da mudança
        !["atendido"].includes(statusAtual);        // "atendido" nunca permite iniciar

    if (podeIniciarAtendimento) {
        btnIniciar.classList.remove("hidden");
        btnIniciar.onclick = () => iniciarAtendimento(id);
    } else {
        btnIniciar.classList.add("hidden");
    }

        // ------ Botão "Ver todas as sessões" ------
        const btnVerTodas = document.getElementById("btnVerTodasSessoes");
        if (temPaciente) {
            btnVerTodas.href = `/pacientes/${event.extendedProps.paciente_id}/sessoes`;
            btnVerTodas.classList.remove("hidden");
        } else {
            btnVerTodas.href = "#";
            btnVerTodas.classList.add("hidden");
        }

        // ------ Botão "Visualizar Atendimento" ------
    // ------ Botão "Visualizar Atendimento" ------
    const btnVisualizar = document.getElementById("btnVisualizarAtendimento");

    const podeVisualizar = ["atendido", "faltou"].includes(status) && temPaciente;

    if (podeVisualizar) {
        btnVisualizar.classList.remove("hidden");
        btnVisualizar.onclick = () =>
            visualizarAtendimento(id, event.extendedProps.paciente_id);
    } else {
        btnVisualizar.classList.add("hidden");
    }

};

// ------------------- VISUALIZAR AGENDAMENTO -------------------
/**
 * Abre modal de visualização do atendimento.
 * Busca informações via API e preenche campos do modal.
 * @param {number|string} consultaId - ID do atendimento
 * @param {number|string} pacienteId - ID do paciente
 */
window.visualizarAtendimento = function(consultaId, pacienteId) {
    fetch(`/api/sessoes/buscar-por-consulta/${consultaId}`)
        .then(res => res.json())
        .then(data => {
            if (!data || !data.id) {
                alert("Nenhuma sessão encontrada para este atendimento.");
                return;
            }

            // Preenche informações principais
            document.getElementById('modalVisualizarTitulo').innerText = `Atendimento: ${data.paciente_nome}`;
            document.getElementById('modalVisualizarData').innerHTML = `<i class="far fa-calendar-alt mr-1"></i> ${data.data_sessao}`;
            document.getElementById('modalVisualizarProfissional').innerHTML = `<i class="far fa-user-circle mr-1"></i> ${data.profissional_nome}`;
            document.getElementById('modalVisualizarConteudo').innerHTML = data.conteudo || '<p class="text-gray-500 italic">Nenhum conteúdo registrado.</p>';

            // Preenche registros adicionais
            const registrosContainer = document.getElementById('modalVisualizarRegistros');
            registrosContainer.innerHTML = '';
            if (data.registros && data.registros.length > 0) {
                data.registros.forEach(r => {
                    const div = document.createElement('div');
                    div.className = 'bg-white border border-gray-300 p-4 rounded-lg shadow-sm hover:shadow-md transition duration-200';
                    div.innerHTML = `
                        <div class="prose prose-sm text-gray-800 leading-snug">${r.conteudo}</div>
                        <p class="text-xs text-right text-gray-500 pt-2 border-t mt-3">
                            <i class="far fa-clock mr-1"></i> Registrado por ${r.usuario_nome} em ${r.created_at}
                        </p>
                    `;
                    registrosContainer.appendChild(div);
                });
            } else {
                // Mensagem caso não haja registros adicionais
                registrosContainer.innerHTML = `
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-yellow-800 text-base">
                        <i class="fas fa-exclamation-circle mr-2"></i> Nenhum registro de anotação adicional encontrado.
                    </p>
                </div>`;
            }

            // Mostra o modal
            const overlay = document.getElementById('modalVisualizarOverlay');
            const card = document.getElementById('modalVisualizarCard');
            overlay.classList.remove('hidden');
            setTimeout(() => card.classList.remove('scale-95', 'opacity-0'), 20);
        })
        .catch(err => {
            console.error("Erro ao buscar sessão:", err);
            alert("Erro ao abrir o atendimento.");
        });
};

// ------------------- FECHAR MODAL DE VISUALIZAÇÃO -------------------
/**
 * Fecha o modal de visualização do atendimento.
 */
function closeVisualizarModal() {
    const overlay = document.getElementById('modalVisualizarOverlay');
    const card = document.getElementById('modalVisualizarCard');
    card.classList.add('scale-95', 'opacity-0');
    setTimeout(() => overlay.classList.add('hidden'), 150);
}

// ------------------- FECHAR AO CLICAR FORA DO CARD -------------------
// Fecha modal quando clicar fora da área do card
document.getElementById('modalVisualizarOverlay').addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeVisualizarModal();
});


// AÇÃO - INICIAR ATENDIMENTO (SWEETALERT2)
window.iniciarAtendimento = function (consultaId) {
    Swal.fire({
        title: "Iniciar Atendimento?",
        text: "Você será direcionado para a página de relato da sessão.",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, Iniciar!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Ação de iniciar (redirecionamento)
            window.location.href = `/consultas/${consultaId}/iniciar-atendimento`;
        }
    });
};

// EXCLUIR agendamento (SWEETALERT2)
window.excluirAgendamento = function (id) {
    Swal.fire({
        title: "Tem certeza?",
        text: "Você não poderá reverter a exclusão deste agendamento!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, Excluir!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            // Remove visualmente ANTES da requisição (fica mais rápido)
            const evento = calendar.getEventById(String(id));
            if (evento) evento.remove();

            fetch(`/consultas/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    Accept: "application/json",
                },
            })
                .then((r) => {
                    if (!r.ok) throw new Error("Erro na exclusão");
                    return r.json();
                })
                .then(() => {
                    // Feedback de Sucesso
                    Swal.fire("Excluído!", "O agendamento foi excluído com sucesso.", "success");
                    calendar.refetchEvents(); // garante sincronia
                    closeModal();
                })
                .catch((err) => {
                    console.error(err);
                    // Feedback de Erro
                    Swal.fire(
                        "Erro!",
                        "Ocorreu um erro ao excluir. Tente novamente.",
                        "error"
                    );
                    calendar.refetchEvents(); // recarrega caso tenha dado errado
                });
        }
    });
};


// MOSTRAR modal (com animação) - (sem alterações)
function showModal() {
    modal.classList.remove("hidden");
    setTimeout(() => {
        modalCard.classList.remove("scale-95", "opacity-0");
        modalCard.classList.add("scale-100", "opacity-100");
    }, 20);
}

// FECHAR modal (com animação + limpeza total) - (sem alterações)
window.closeModal = function () {
    modalCard.classList.add("scale-95", "opacity-0");
    setTimeout(() => {
        modal.classList.add("hidden");
        resetarModal(); // ← garante que na próxima abertura esteja 100% limpo
    }, 150);
};

// Fechar ao clicar fora - (sem alterações)
modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
});

// Função auxiliar pra mostrar toast
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

