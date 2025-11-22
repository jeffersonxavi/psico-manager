/* ---------------- HEADER CUSTOMIZADO ---------------- */

// Renderizar header semanal
window.renderHeader = function (info) {
    const container = document.getElementById("customHeader");
    container.innerHTML = "";

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
        container.appendChild(div);
    }
};

window.updateTitle = function (info) {
    const start = moment(info.start).format("D");
    const end = moment(info.end).subtract(1, "day").format("D MMM");
    document.getElementById("title").innerText = `Semana ${start} - ${end}`;
};

/* Botões */
document.getElementById("prevBtn").onclick = () => calendar.prev();
document.getElementById("nextBtn").onclick = () => calendar.next();
document.getElementById("todayBtn").onclick = () => calendar.today();

document.getElementById("weekBtn").onclick = () => {
    calendar.changeView("timeGridWeek");
};

document.getElementById("monthBtn").onclick = () => {
    calendar.changeView("dayGridMonth");
};
