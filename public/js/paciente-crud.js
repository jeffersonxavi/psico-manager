/* Salvar Paciente via AJAX */
document.getElementById("btnSalvarPaciente").addEventListener("click", () => {
    const form = document.getElementById("formPaciente");
    const formData = new FormData(form);

    fetch("/pacientes", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: formData,
    })
        .then((r) => r.json())
        .then((r) => {
            if (r.success) {
                alert(r.message);
                closePacienteModal();
                location.reload();
            }
        })
        .catch((err) => console.error(err));
});
