/* ---------------- MODAL PACIENTE---------------- */
let pacienteModal = document.getElementById("pacienteModalOverlay");
let pacienteModalCard = document.getElementById("pacienteModalCard");

function openPacienteModal() {
    pacienteModal.classList.remove("hidden");
    setTimeout(() => {
        pacienteModalCard.classList.remove("scale-95", "opacity-0");
        pacienteModalCard.classList.add("scale-100", "opacity-100");
    }, 20);
}

function closePacienteModal() {
    pacienteModalCard.classList.add("scale-95", "opacity-0");
    setTimeout(() => pacienteModal.classList.add("hidden"), 150);
}

pacienteModal.addEventListener("click", function (e) {
    if (e.target === pacienteModal) closePacienteModal();
});

/* ---------------- CRIAR PACIENTE AJAX ---------------- */
document.getElementById("btnSalvarPaciente").addEventListener("click", function () {
    const form = document.getElementById("formPaciente");
    const formData = new FormData(form);

    fetch("/pacientes", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") },
        body: formData
    })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert(res.message);
                closePacienteModal();
                location.reload(); // Atualiza select de pacientes
            }
        })
        .catch(err => console.error(err));
});


/* ---------------- MODAL AGENDAMENTO ---------------- */
let modal = document.getElementById("modalOverlay");
let modalCard = document.getElementById("modalCard");

window.openModal = function (info = null) {
    modal.classList.remove("hidden");

    setTimeout(() => {
        modalCard.classList.remove("scale-95", "opacity-0");
        modalCard.classList.add("scale-100", "opacity-100");
    }, 20);

    document.getElementById("modalTitle").innerText =
        info && info.event ? "Editar Agendamento" : "Novo Agendamento";

    if (info && info.event) {
        const start = moment(info.event.start);
        const end = moment(info.event.end || start.clone().add(30, "minutes"));

        document.getElementById("modalDate").value = start.format("YYYY-MM-DD");
        document.getElementById("modalStart").value = start.format("HH:mm");
        document.getElementById("modalEnd").value = end.format("HH:mm");
    }
    // SE FOR SELEÇÃO NA AGENDA (NOVO)
    else if (info && info.start) {
        const start = moment(info.start);
        const end = moment(info.end || start.clone().add(30, "minutes"));

        document.getElementById("modalDate").value = start.format("YYYY-MM-DD");
        document.getElementById("modalStart").value = start.format("HH:mm");
        document.getElementById("modalEnd").value = end.format("HH:mm");
    }

    if (info && info.event) {
        document.getElementById("btnSalvarAgendamento").onclick = () => updateAgendamento(info.event.id);
    } else {
        document.getElementById("btnSalvarAgendamento").onclick = salvarAgendamento;
    }
};

window.closeModal = function () {
    modalCard.classList.add("scale-95", "opacity-0");
    setTimeout(() => {
        modal.classList.add("hidden");
    }, 150);
};

modal.addEventListener("click", function (e) {
    if (e.target === modal) closeModal();
});

/* ---------------- CALENDÁRIO ---------------- */
document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    const customHeaderEl = document.getElementById("customHeader");
    moment.locale("pt-br");

    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "pt-br",
        timeZone: 'local',
        initialView: "timeGridWeek",
        headerToolbar: false,
        height: "auto",
        slotMinTime: "07:00",
        slotMaxTime: "20:00",
        slotDuration: "00:30:00",
        selectable: true,
        editable: false,

        events: "/api/consultas",
        

        select: function (info) {
            openModal({ start: info.start, end: info.end });
        },

        eventClick: function(info) {

            const event = info.event;

            // Preenche os campos do formulário
            document.getElementById("paciente_id").value = event.extendedProps.paciente_id;
            document.getElementById("titulo").value = event.extendedProps.titulo;
            document.getElementById("status").value = event.extendedProps.status;

            // Preenche datas e horários
            const inicio = event.start;
            const fim = event.end;

            document.getElementById("modalDate").value = inicio.toISOString().substring(0, 10);
            document.getElementById("modalStart").value = inicio.toTimeString().substring(0, 5);
            document.getElementById("modalEnd").value = fim.toTimeString().substring(0, 5);

            // Define que o modal está editando
            window.currentEventId = event.id;

            // Abrir modal
            openModal(info);
        },

        datesSet: function (info) {
            renderHeader(info);
            updateTitle(info);
        },
    });

    calendar.render();

    /* ---- HEADER DOS DIAS ---- */
    function renderHeader(info) {
        customHeaderEl.innerHTML = "";
        const start = moment(info.start);

        for (let i = 0; i < 7; i++) {
            const day = start.clone().add(i, "days");
            const div = document.createElement("div");
            div.className = "day-header flex-1 cursor-pointer";
            div.innerHTML = `
                <div>${day.format("ddd").toUpperCase()}</div>
                <div class="${day.isSame(moment(), "day") ? "day-number highlight" : "day-number"}">
                    ${day.format("D")}
                </div>
            `;
            div.onclick = () => calendar.changeView("timeGridDay", day.format("YYYY-MM-DD"));
            customHeaderEl.appendChild(div);
        }
    }

    function updateTitle(info) {
        const start = moment(info.start).format("D");
        const end = moment(info.end).subtract(1, "day").format("D MMM");
        document.getElementById("title").textContent = `Semana ${start} - ${end}`;
    }

    document.getElementById("prevBtn").onclick = () => calendar.prev();
    document.getElementById("nextBtn").onclick = () => calendar.next();
    document.getElementById("todayBtn").onclick = () => calendar.today();

    document.getElementById("weekBtn").onclick = () => {
        calendar.changeView("timeGridWeek");
        setActive("timeGridWeek");
    };
    document.getElementById("monthBtn").onclick = () => {
        calendar.changeView("dayGridMonth");
        setActive("dayGridMonth");
    };

    function setActive(view) {
        const buttons = { dayGridMonth: "monthBtn", timeGridWeek: "weekBtn" };
        for (let key in buttons) {
            const btn = document.getElementById(buttons[key]);
            btn.classList.toggle("bg-blue-600", key === view);
            btn.classList.toggle("text-white", key === view);
            btn.classList.toggle("bg-gray-100", key !== view);
            btn.classList.toggle("text-gray-600", key !== view);
        }
    }
    /* ---------------- FUNÇÕES CRUD AGENDAMENTO ---------------- */
    window.salvarAgendamento = function() {
        const form = document.getElementById("formAgendamento");

        const date = document.getElementById("modalDate").value;
        const start = document.getElementById("modalStart").value;
        const end = document.getElementById("modalEnd").value;

        const formData = new FormData(form);

        // Combina data + hora
        formData.set('data_hora_inicio', `${date} ${start}`);
        formData.set('data_hora_fim', `${date} ${end}`);

        fetch("/consultas", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                calendar.refetchEvents();
                closeModal();
                alert(res.message);
            } else {
                console.error(res.errors);
                alert("Erro ao salvar: veja o console");
            }
        })
        .catch(err => console.error(err));
    };


    window.updateAgendamento = function(id) {
        const formData = new FormData(document.getElementById("formAgendamento"));
        fetch(`/consultas/${id}`, {
            method: "PUT",
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                calendar.refetchEvents();
                closeModal();
                alert(res.message);
            }
        })
        .catch(err => console.error(err));
    };

    window.deleteAgendamento = function(id) {
        if (!confirm("Deseja realmente excluir este agendamento?")) return;
        fetch(`/consultas/${id}`, {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                calendar.refetchEvents();
                alert(res.message);
            }
        })
        .catch(err => console.error(err));
    };
    
});
