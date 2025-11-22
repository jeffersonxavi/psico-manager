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
};

// ABRE modal (edição)
window.openModalEdicao = function (info) {
    showModal();

    const event = info.event;
    document.getElementById("modalTitle").innerText = "Editar Agendamento";

    document.getElementById("paciente_id").value = event.extendedProps.paciente_id;
    document.getElementById("titulo").value = event.extendedProps.titulo;
    document.getElementById("status").value = event.extendedProps.status;

    document.getElementById("modalDate").value = moment(event.start).format("YYYY-MM-DD");
    document.getElementById("modalStart").value = moment(event.start).format("HH:mm");
    document.getElementById("modalEnd").value = moment(event.end).format("HH:mm");

    const id = event.id;
    document.getElementById("btnSalvarAgendamento").onclick = () => updateAgendamento(id);
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
