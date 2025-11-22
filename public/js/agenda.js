/* =========================================================================
   AGENDA – SCRIPT PRINCIPAL
   Organização:
   1. Inicialização e Configurações
   2. Calendar FullCalendar
   3. Modal Paciente (CRUD)
   4. Modal Agendamento + CRUD
   5. Header customizado da Semana
   6. Botões de navegação (Semana/Mês)
   ========================================================================= */

/* -------------------------------------------------------------------------
   1. CONFIGURAÇÃO INICIAL
------------------------------------------------------------------------- */
document.addEventListener("DOMContentLoaded", function () {
    moment.locale("pt-br");

    const calendarEl = document.getElementById("calendar");
    const customHeaderEl = document.getElementById("customHeader");

    /* =====================================================================
       2. CALENDÁRIO FULLCALENDAR
    ===================================================================== */
    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "pt-br",
        timeZone: "local",
        initialView: "timeGridWeek",
        headerToolbar: false,
        height: "auto",
        slotMinTime: "07:00",
        slotMaxTime: "20:00",
        slotDuration: "00:30:00",
        selectable: true,
        editable: false,

        events: "/api/consultas",

        /* Criar agendamento selecionando a grade */
        select(info) {
            openAgendamentoModal({ start: info.start, end: info.end });
        },

        /* Editar agendamento clicado */
        eventClick(info) {
            preencherModalEdicao(info.event);
            openAgendamentoModal({ event: info.event });
        },

        /* Atualiza cabeçalho da semana */
        datesSet(info) {
            renderHeader(info);
            updateTitle(info);
        },
    });

    calendar.render();

    /* =========================================================================
       3. MODAL PACIENTE
    ========================================================================= */
    const pacienteModal = document.getElementById("pacienteModalOverlay");
    const pacienteModalCard = document.getElementById("pacienteModalCard");

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

    pacienteModal.addEventListener("click", e => {
        if (e.target === pacienteModal) closePacienteModal();
    });

    /* Salvar Paciente via AJAX */
    document.getElementById("btnSalvarPaciente").addEventListener("click", () => {
        const form = document.getElementById("formPaciente");
        const formData = new FormData(form);

        fetch("/pacientes", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: formData,
        })
            .then(r => r.json())
            .then(r => {
                if (r.success) {
                    alert(r.message);
                    closePacienteModal();
                    location.reload();
                }
            })
            .catch(err => console.error(err));
    });

    /* =========================================================================
       4. MODAL AGENDAMENTO + CRUD
    ========================================================================= */

    const modal = document.getElementById("modalOverlay");
    const modalCard = document.getElementById("modalCard");

    /* -------- Abrir Modal (Novo ou Editar) -------- */
    window.openAgendamentoModal = function (info = null) {
        modal.classList.remove("hidden");
        setTimeout(() => {
            modalCard.classList.remove("scale-95", "opacity-0");
            modalCard.classList.add("scale-100", "opacity-100");
        }, 20);

        document.getElementById("modalTitle").innerText =
            info && info.event ? "Editar Agendamento" : "Novo Agendamento";

        preencherCamposDoModal(info);
        configurarBotaoDeSalvar(info);
    };

    /* -------- Fechar Modal -------- */
    window.closeModal = function () {
        modalCard.classList.add("scale-95", "opacity-0");
        setTimeout(() => modal.classList.add("hidden"), 150);
    };

    modal.addEventListener("click", e => {
        if (e.target === modal) closeModal();
    });

    /* -------- Preencher Modal ao Editar -------- */
    function preencherModalEdicao(event) {
        document.getElementById("paciente_id").value = event.extendedProps.paciente_id;
        document.getElementById("titulo").value = event.extendedProps.titulo;
        document.getElementById("status").value = event.extendedProps.status;

        document.getElementById("modalDate").value = event.start.toISOString().substring(0, 10);
        document.getElementById("modalStart").value = event.start.toTimeString().substring(0, 5);
        document.getElementById("modalEnd").value = event.end.toTimeString().substring(0, 5);
    }

    /* -------- Preencher Campos ao Criar/Editar -------- */
    function preencherCamposDoModal(info) {
        if (!info) return;

        if (info.event) return; // já preenchido

        const start = moment(info.start);
        const end = moment(info.end || start.clone().add(30, "minutes"));

        document.getElementById("modalDate").value = start.format("YYYY-MM-DD");
        document.getElementById("modalStart").value = start.format("HH:mm");
        document.getElementById("modalEnd").value = end.format("HH:mm");
    }

    /* -------- Nova Consulta vs Atualização -------- */
    function configurarBotaoDeSalvar(info) {
        if (info && info.event) {
            document.getElementById("btnSalvarAgendamento").onclick = () =>
                updateAgendamento(info.event.id);
        } else {
            document.getElementById("btnSalvarAgendamento").onclick = salvarAgendamento;
        }
    }

    /* ----------------------- Criar Agendamento ----------------------- */
    window.salvarAgendamento = function () {
        const formData = montarFormDeAgendamento();

        fetch("/consultas", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                Accept: "application/json",
            },
            body: formData,
        })
            .then(r => r.json())
            .then(r => {
                if (r.success) {
                    calendar.refetchEvents();
                    closeModal();
                    alert(r.message);
                } else {
                    console.error(r.errors);
                    alert("Erro ao salvar");
                }
            });
    };

    /* ----------------------- Atualizar Agendamento ----------------------- */
    window.updateAgendamento = function (id) {
        const formData = montarFormDeAgendamento();
        formData.append("_method", "PUT");

        fetch(`/consultas/${id}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                Accept: "application/json",
            },
            body: formData,
        })
            .then(r => r.json())
            .then(r => {
                if (r.success) {
                    calendar.refetchEvents();
                    closeModal();
                    alert(r.message);
                }
            });
    };

    /* ----------------------- EXCLUIR AGENDA ----------------------- */
    window.deleteAgendamento = function (id) {
        if (!confirm("Deseja realmente excluir?")) return;

        fetch(`/consultas/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
        })
            .then(r => r.json())
            .then(r => {
                if (r.success) {
                    calendar.refetchEvents();
                    alert(r.message);
                }
            });
    };

    /* -------- Função auxiliar para montar FormData -------- */
    function montarFormDeAgendamento() {
        const form = document.getElementById("formAgendamento");
        const FD = new FormData(form);

        const date = document.getElementById("modalDate").value;
        const start = document.getElementById("modalStart").value;
        const end = document.getElementById("modalEnd").value;

        FD.set("data_hora_inicio", `${date} ${start}`);
        FD.set("data_hora_fim", `${date} ${end}`);

        return FD;
    }

    /* =========================================================================
       5. HEADER PERSONALIZADO DA SEMANA
    ========================================================================= */
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

    /* =========================================================================
       6. BOTÕES DE NAVEGAÇÃO
    ========================================================================= */
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
});
