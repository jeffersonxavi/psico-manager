/* ---------------- MODAL PACIENTE ---------------- */

let pacienteModal = document.getElementById("pacienteModalOverlay");
let pacienteModalCard = document.getElementById("pacienteModalCard");

// ABRE modal
window.openPacienteModal = function () {
    pacienteModal.classList.remove("hidden");

    setTimeout(() => {
        pacienteModalCard.classList.remove("scale-95", "opacity-0");
        pacienteModalCard.classList.add("scale-100", "opacity-100");
    }, 20);
};

// FECHAR modal
window.closePacienteModal = function () {
    pacienteModalCard.classList.add("scale-95", "opacity-0");
    setTimeout(() => pacienteModal.classList.add("hidden"), 150);
};

pacienteModal.addEventListener("click", (e) => {
    if (e.target === pacienteModal) closePacienteModal();
});
