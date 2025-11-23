/* ---------------- MODAL DE AGENDAMENTO ---------------- */

let modal = document.getElementById("modalOverlay");
let modalCard = document.getElementById("modalCard");

// ABRE modal (novo)
window.openModalAgendamento = function (info) {
    showModal();

    document.getElementById("modalTitle").innerText = "Novo Agendamento";

    const start = moment(info.start);
    const end = moment(info.end || start.clone().add(30, "minutes"));

    document.getElementById("modalDate").value = start.format("YYYY-MM-DD");
    document.getElementById("modalStart").value = start.format("HH:mm");
    document.getElementById("modalEnd").value = end.format("HH:mm");

    document.getElementById("btnSalvarAgendamento").onclick = salvarAgendamento;
    // esconder botão excluir
    document.getElementById("btnExcluirAgendamento").classList.add("hidden");
};

// ABRE modal (edição)
window.openModalEdicao = function (info) {
    showModal();

    const event = info.event;
    const id = event.id;
    document.getElementById("modalTitle").innerText = "Editar Agendamento";

    document.getElementById("paciente_id").value = event.extendedProps.paciente_id;
    document.getElementById("titulo").value = event.extendedProps.titulo;
    document.getElementById("status").value = event.extendedProps.status;
    document.getElementById("modalDate").value = moment(event.start).format("YYYY-MM-DD");
    document.getElementById("modalStart").value = moment(event.start).format("HH:mm");
    document.getElementById("modalEnd").value = moment(event.end).format("HH:mm");

      // Salvar vira UPDATE
    document.getElementById("btnSalvarAgendamento").onclick = () => updateAgendamento(id);

    // Mostrar botão de excluir
    const btnExcluir = document.getElementById("btnExcluirAgendamento");
    btnExcluir.classList.remove("hidden");
    btnExcluir.onclick = () => excluirAgendamento(id);
};
window.excluirAgendamento = function(id) {

    if (!confirm("Tem certeza que deseja excluir este agendamento?")) {
        return;
    }

    fetch(`/consultas/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => {
        if (!res.ok) throw new Error("Erro ao excluir");
        return res.json();
    })
    .then(() => {
        calendar.refetchEvents();
        closeModal();
    })
    .catch(err => console.error(err));
};

// MOSTRAR modal
function showModal() {
    modal.classList.remove("hidden");
    setTimeout(() => {
        modalCard.classList.remove("scale-95", "opacity-0");
        modalCard.classList.add("scale-100", "opacity-100");
    }, 20);
}

// FECHAR modal
window.closeModal = function () {
    modalCard.classList.add("scale-95", "opacity-0");
    setTimeout(() => modal.classList.add("hidden"), 150);
};

modal.addEventListener("click", (e) => {
    if (e.target === modal) closeModal();
});
