/* ---------------- CALENDÁRIO ---------------- */
document.addEventListener("DOMContentLoaded", function () {

    const calendarEl = document.getElementById("calendar");
    const customHeaderEl = document.getElementById("customHeader");
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
        editable: false,
        events: "/api/consultas",

        // Criar agendamento ao selecionar
        select: (info) => openModalAgendamento(info),

        // Editar ao clicar
        eventClick: (info) => openModalEdicao(info),

        // Atualizar header customizado
        datesSet: (info) => {
            renderHeader(info);
            updateTitle(info);
        }
    });

    calendar.render();
});
