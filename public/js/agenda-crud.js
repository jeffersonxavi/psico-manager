/* ---------------- CRUD AGENDAMENTOS ---------------- */

window.salvarAgendamento = function () {
    const form = document.getElementById("formAgendamento");
    const formData = new FormData(form);

    const date = document.getElementById("modalDate").value;
    const start = document.getElementById("modalStart").value;
    const end = document.getElementById("modalEnd").value;

    formData.set("data_hora_inicio", `${date} ${start}`);
    formData.set("data_hora_fim", `${date} ${end}`);

    fetch("/consultas", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf(),
            Accept: "application/json",
        },
        body: formData
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                calendar.refetchEvents();
                closeModal();
            }
        });
};

window.updateAgendamento = function (id) {
    const form = document.getElementById("formAgendamento");
    const formData = new FormData(form);

    const date = document.getElementById("modalDate").value;
    const start = document.getElementById("modalStart").value;
    const end = document.getElementById("modalEnd").value;

    formData.set("data_hora_inicio", `${date} ${start}`);
    formData.set("data_hora_fim", `${date} ${end}`);

    fetch(`/consultas/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf(),
            Accept: "application/json",
            "X-HTTP-Method-Override": "PUT",
        },
        body: formData
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                calendar.refetchEvents();
                closeModal();
            }
        });
};

window.deleteAgendamento = function (id) {
    if (!confirm("Deseja realmente excluir?")) return;

    fetch(`/consultas/${id}`, {
        method: "DELETE",
        headers: { "X-CSRF-TOKEN": csrf() }
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                calendar.refetchEvents();
            }
        });
};

function csrf() {
    return document.querySelector('meta[name="csrf-token"]').content;
}
