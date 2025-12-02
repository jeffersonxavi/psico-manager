/* ---------------- MODAL DE AGENDAMENTO (Refatorado com SweetAlert2) ---------------- */

const modal = document.getElementById("modalOverlay");
const modalCard = document.getElementById("modalCard");

// FUNÇÃO DE LIMPEZA TOTAL (sem alterações)
function resetarModal() {
    const form = document.getElementById("formAgendamento");
    if (form) form.reset();

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

// ABRE modal (NOVO agendamento) - (sem alterações)
window.openModalAgendamento = function (info) {
    showModal();
    resetarModal();

    document.getElementById("modalTitle").innerText = "Novo Agendamento";

    const start = moment(info.start);
    const end = moment(info.end || start.clone().add(30, "minutes"));

    document.getElementById("modalDate").value = start.format("YYYY-MM-DD");
    document.getElementById("modalStart").value = start.format("HH:mm");
    document.getElementById("modalEnd").value = end.format("HH:mm");

    document.getElementById("btnSalvarAgendamento").onclick = salvarAgendamento;
};

// ABRE modal (EDIÇÃO + INICIAR ATENDIMENTO) - (sem alterações)
window.openModalEdicao = function(info) {
    showModal();
    resetarModal();

    const event = info.event;
    const id = String(event.id);

    document.getElementById("modalTitle").innerText = "Editar Agendamento";

    // Preenche campos
    document.getElementById("paciente_id").value = event.extendedProps.paciente_id || "";
    document.getElementById("titulo").value = event.extendedProps.titulo ?? event.title?.split(" - ").at(-1)?.trim() ?? "";
    document.getElementById("status").value = event.extendedProps.status || "agendado";
    document.getElementById("observacoes").value = event.extendedProps.observacoes ?? "";
    const inicio = moment.parseZone(event.start).local();
    const fim = event.end ? moment.parseZone(event.end).local() : inicio.clone().add(50, "minutes");

    document.getElementById("modalDate").value = inicio.format("YYYY-MM-DD");
    document.getElementById("modalStart").value = inicio.format("HH:mm");
    document.getElementById("modalEnd").value = fim.format("HH:mm");

    // Botão salvar
    document.getElementById("btnSalvarAgendamento").onclick = () => updateAgendamento(id);

    // Botão excluir
    const btnExcluir = document.getElementById("btnExcluirAgendamento");
    btnExcluir.classList.remove("hidden");
    btnExcluir.onclick = () => excluirAgendamento(id);

    // ------------------- BOTÃO INICIAR ATENDIMENTO -------------------
    const btnIniciar = document.getElementById("btnIniciarAtendimento");
    const hoje = moment().startOf("day");
    const diaConsulta = inicio.clone().startOf("day");
    const agora = moment();
    const status = event.extendedProps.status;
    const temPaciente = !!event.extendedProps.paciente_id;

    // Oculta botão para dias anteriores
    if (diaConsulta.isBefore(hoje) || !["agendado", "confirmado"].includes(status) || !temPaciente) {
        btnIniciar.classList.add("hidden");
    } else {
        btnIniciar.classList.remove("hidden");
        btnIniciar.onclick = () => iniciarAtendimento(id);
    }
};


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