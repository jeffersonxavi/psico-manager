/* ---------------- CALENDÁRIO OTIMIZADO ---------------- */
document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById("calendar");
    moment.locale("pt-br");

    window.calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "pt-br",
        timeZone: "local",
        initialView: "timeGridWeek",
        headerToolbar: false,
        height: "auto",
        slotMinTime: "07:00",
        slotMaxTime: "20:00",
        slotDuration: "00:30:00",
        selectable: true,

        // 🚨 MUDANÇA CRÍTICA 1: Habilitar Edição
        editable: true,
        eventMinDuration: "00:30:00", // Duração mínima de 30 minutos
        snapDuration: "00:15:00", // Ajusta o arraste e redimensionamento a cada 15 minutos
        eventConstraint: {
            // Restringe movimento aos limites da agenda
            startTime: "07:00",
            endTime: "20:00",
        },

        // ----------------------------------------
        events: "/api/consultas",

        // Função que controla o conteúdo do card
        eventContent(info) {
            const start = info.event.start;
            const end = info.event.end || start;
            const minutes = Math.round((end - start) / 60000); // duração em minutos

            const hora = moment(start).format("HH:mm");

            // Título no formato "Jefferson Batista da Silva - Terapia Individual"
            const [nomeCompleto = "", titulo = ""] = (
                info.event.title || ""
            ).split(" - ");
            const nomePartes = nomeCompleto.trim().split(" ");
            const nomeCurto = nomePartes.slice(0, 2).join(" "); // só primeiro + segundo nome

            const status = (
                info.event.extendedProps.status || "agendado"
            ).toLowerCase();

            const cores = {
                agendado: "bg-gray-300",
                confirmado: "bg-blue-400",
                atendido: "bg-green-400",
                faltou: "bg-yellow-400",
                desmarcado: "bg-red-400",
            };
            const corStatus = cores[status] || "bg-gray-300";

            // ULTRA-COMPACTO para 15 minutos ou menos
            if (minutes <= 15) {
                return {
                    html: `
                        <div class="fc-event-ultra-compact">
                            <div class="uc-top">
                                <span class="uc-hora">${hora}</span>
                                <span class="uc-bolinha" style="background:${corStatus}"></span>
                            </div>
                            <div class="uc-nome">${nomeCurto}</div>
                        </div>
                    `,
                };
            }

            // Modo normal (acima de 15 min)
            return {
                html: `
                    <div class="ev-card">
                        <div class="ev-row-top">
                            <span class="ev-time">${hora}</span>
                            <span class="ev-status ${corStatus} text-white text-xs px-2 py-0.5 rounded capitalize">${status}</span>
                        </div>
                        <div class="ev-name">${nomeCurto}</div>
                        ${titulo ? `<div class="ev-title">${titulo}</div>` : ""}
                    </div>
                `,
            };
        },
        // Criar agendamento ao selecionar
        select: (info) => openModalAgendamento(info),
        // Editar ao clicar
        eventClick: (info) => openModalEdicao(info),
        // 🚨 MUDANÇA CRÍTICA 2: Capturar evento ao Mover (Drag & Drop)
        eventDrop: (info) => updateAgendamentoExterno(info.event),
        // 🚨 MUDANÇA CRÍTICA 3: Capturar evento ao Redimensionar
        eventResize: (info) => updateAgendamentoExterno(info.event),

        // Atualizar header customizado
        datesSet: (info) => {
            renderHeader(info);
            updateTitle(info);
        },
    });

    calendar.render();
});

/* ---------------- ATUALIZAÇÃO SEM MODAL (DRAG & DROP / RESIZE) ---------------- */
window.updateAgendamentoExterno = function (event) {
    const id = event.id;

    // Formata o novo início e fim
    const start = moment(event.start).format("YYYY-MM-DD HH:mm:ss");
    const end = moment(event.end || event.start).format("YYYY-MM-DD HH:mm:ss");

    // ✅ DADOS OBRIGATÓRIOS: Extraídos de extendedProps (onde a API os colocou)
    const pacienteId = event.extendedProps.paciente_id;
    const status = event.extendedProps.status || "agendado"; // Garante um status padrão

    // O título e as observações não são obrigatórios nesta atualização

    const formData = new FormData();
    formData.append("data_hora_inicio", start);
    formData.append("data_hora_fim", end);

    // 💡 CAMPO CRÍTICO: Agora enviamos o ID do paciente para passar na validação do Laravel
    formData.append("paciente_id", pacienteId);

    // Opcional, mas recomendado enviar o status e título para a validação
    formData.append("status", status);
    formData.append("titulo", event.extendedProps.titulo || "Agendamento");

    console.log(
        `Atualizando D&D: ID ${id}, Paciente ${pacienteId}, Início ${start}`
    );

    fetch(`/consultas/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrf(),
            Accept: "application/json",
            "X-HTTP-Method-Override": "PUT", // Simula o método PUT
        },
        body: formData,
    })
        .then((r) => r.json())
        .then((res) => {
            if (res.success) {
                console.log(
                    "Agendamento atualizado via Drag/Resize com sucesso!"
                );
                // Não precisa do refetchEvents aqui, o FullCalendar já moveu visualmente.
            } else {
                // Em caso de erro (ex: falha de validação mais complexa), reverte
                console.error("Erro na validação do servidor:", res);
                calendar.refetchEvents();
            }
        })
        .catch((error) => {
            console.error("Erro de rede/servidor:", error);
            calendar.refetchEvents(); // Reverte em caso de falha de comunicação
        });
};
