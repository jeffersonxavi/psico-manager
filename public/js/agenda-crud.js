/* ---------------- CRUD AGENDAMENTOS ---------------- */

// Função auxiliar pra mostrar toast (melhor que alert comum)
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: ( poorest) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.salvarAgendamento = function () {
    const form = document.getElementById("formAgendamento");
    const formData = new FormData(form);

    const date = document.getElementById("modalDate").value;
    const start = document.getElementById("modalStart").value;
    const end = document.getElementById("modalEnd").value;

    formData.set("data_hora_inicio", `${date} ${start}`);
    formData.set("data_hora_fim", `${date} ${end}`);

    // Loading bonito enquanto salva
    Swal.fire({
        title: 'Salvando agendamento...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch("/consultas", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf(),
            "Accept": "application/json",
        },
        body: formData
    })
    .then(r => {
        if (!r.ok) throw r;
        return r.json();
    })
    .then(res => {
        if (res.success) {
            calendar.refetchEvents();
            closeModal();

            Swal.fire({
                icon: 'success',
                title: 'Pronto!',
                text: 'Agendamento criado com sucesso!',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            throw res;
        }
    })
    .catch(err => {
        console.error(err);

        let message = 'Erro ao salvar o agendamento.';
        if (err.errors) {
            message = Object.values(err.errors).flat().join('<br>');
        } else if (err.message) {
            message = err.message;
        }

        Swal.fire({
            icon: 'error',
            title: 'Ops...',
            html: message,
            confirmButtonColor: '#d33'
        });
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

    /* Swal.fire({
        title: 'Atualizando...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    }); */

    fetch(`/consultas/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf(),
            "Accept": "application/json",
            "X-HTTP-Method-Override": "PUT",
        },
        body: formData
    })
    .then(r => {
        if (!r.ok) throw r;
        return r.json();
    })
    .then(res => {
        if (res.success) {
            calendar.refetchEvents();
            closeModal();

            Toast.fire({
                icon: 'success',
                title: 'Agendamento atualizado!'
            });
        } else {
            throw res;
        }
    })
    .catch(err => {
        console.error(err);

        let message = 'Erro ao atualizar o agendamento.';
        if (err.errors) {
            message = Object.values(err.errors).flat().join('<br>');
        } else if (err.message) {
            message = err.message;
        }

        Swal.fire({
            icon: 'error',
            title: 'Falha na atualização',
            html: message,
            confirmButtonText: 'Entendi'
        });
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
