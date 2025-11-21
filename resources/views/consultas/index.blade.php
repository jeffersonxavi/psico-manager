@extends('layouts.app')
@section('title', 'Agenda')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.min.css' rel='stylesheet' />

<style>
    /* -----------------------------------------------------------
   VARIÁVEIS GERAIS
----------------------------------------------------------- */
    :root {
        --fc-today-bg-color: #f8fafc;
        --fc-border-color: #e5e7eb;
        --fc-text-muted: #6b7280;
        --fc-primary: #3b82f6;
        --fc-primary-light: #eff6ff;
    }

    /* -----------------------------------------------------------
   RESET DO HEADER NATIVO
----------------------------------------------------------- */
    .fc-col-header {
        display: none !important;
    }

    /* Remove bordas duplas */
    .fc-scrollgrid-section-body .fc-timegrid-cols table {
        border-left: none !important;
        border-right: none !important;
    }

    .fc-timegrid-col {
        border-right: 1px solid var(--fc-border-color);
    }

    .fc-timegrid-col:last-child {
        border-right: none !important;
    }

    .fc-timegrid-axis-frame {
        border-bottom: none !important;
    }

    /* -----------------------------------------------------------
   COLUNA DE HORAS
----------------------------------------------------------- */
    .fc-timegrid-slots col:first-child,
    .fc-timegrid-cols col:first-child,
    .fc-timegrid-axis {
        width: 80px !important;
        min-width: 80px !important;
        max-width: 80px !important;
        background: #f9fafb;
        font-weight: 500;
        border-right: 1px solid var(--fc-border-color);
    }

    .fc-timegrid-slot-label {
        text-align: right !important;
        padding-right: 14px !important;
        color: var(--fc-text-muted);
        font-size: 0.85rem;
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        height: 100%;
        padding-top: 0px !important;
    }

    .fc-timegrid-axis-cushion {
        margin-top: -6px;
        line-height: 1.1;
    }

    /* -----------------------------------------------------------
   ALTURA DAS LINHAS (VISUAL PREMIUM)
----------------------------------------------------------- */
    .fc-timegrid-slot {
        height: 50px;
    }

    .fc-timegrid-slot-minor {
        height: 25px;
        border-color: #f1f5f9;
    }

    .fc-timegrid-slot:not(.fc-timegrid-slot-minor) {
        border-top: 1px solid var(--fc-border-color);
    }

    /* -----------------------------------------------------------
   ESTILO DE EVENTOS (PROFISSIONAL)
----------------------------------------------------------- */
    .fc-event {
        background: var(--fc-primary-light);
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 6px 8px;
        color: var(--fc-primary);
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        transition: 0.15s ease;
    }

    .fc-event:hover {
        background: #e0f2fe;
        border-color: var(--fc-primary);
        transform: scale(1.02);
    }

    .fc-event-main-frame {
        line-height: 1.25;
    }

    .event-time {
        font-size: 0.75rem;
        font-weight: 600;
        opacity: 0.9;
    }

    .event-title {
        font-size: 0.87rem;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* -----------------------------------------------------------
   CABEÇALHO CUSTOMIZADO
----------------------------------------------------------- */
    .custom-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: white;
        border-top: 1px solid var(--fc-border-color);
        border-bottom: 1px solid var(--fc-border-color);
    }

    .day-header {
        padding: 12px 4px;
        text-align: center;
        border-right: 1px solid var(--fc-border-color);
    }

    .day-header:last-child {
        border-right: none;
    }

    .day-name {
        font-size: 0.75rem;
        color: var(--fc-text-muted);
        letter-spacing: 0.5px;
    }

    .day-number {
        margin-top: 4px;
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }

    .day-number.highlight {
        background: var(--fc-primary);
        color: white;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 6px auto 0;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush


@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto p-4 sm:p-6">

        <!-- NAV E BOTÕES -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <button id="monthBtn" class="viewBtn px-4 py-2 text-sm font-medium bg-gray-100 text-gray-600">Mês</button>
                    <button id="weekBtn" class="viewBtn px-4 py-2 text-sm font-medium bg-blue-600 text-white">Semana</button>

                    <div class="flex items-center border border-gray-300 rounded-md ml-6">
                        <button id="prevBtn" class="p-2 hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <span id="title" class="px-4 font-semibold text-gray-700">Semana</span>

                        <button id="nextBtn" class="p-2 hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <button id="todayBtn" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-md border border-gray-300">
                        Hoje
                    </button>
                </div>

                <!-- BOTÃO NOVO PACIENTE -->
                <button onclick="openPacienteModal()" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-xl shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Novo Paciente
                </button>
            </div>
        </div>

        <!-- HEADER DOS DIAS -->
        <div class="custom-header flex border-x border-gray-200">
            <div class="w-20 flex-shrink-0"></div>
            <div id="customHeader" class="flex flex-1"></div>
        </div>

        <!-- CALENDÁRIO -->
        <div class="bg-white rounded-b-lg shadow-sm border border-gray-200 border-t-0 overflow-hidden">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- MODAL NOVO PACIENTE -->
<div id="pacienteModalOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center">
    <div id="pacienteModalCard" class="bg-white w-full max-w-2xl rounded-xl shadow-2xl p-6 transform scale-95 opacity-0 transition-all">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Novo Paciente</h2>
            <button onclick="closePacienteModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <form id="formPaciente" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Nome Completo</label>
                    <input type="text" name="nome" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Nome do Paciente" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" class="w-full mt-1 border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Telefone</label>
                    <input type="tel" name="telefone" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="(99) 99999-9999">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">E-mail</label>
                    <input type="email" name="email" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="email@exemplo.com">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Contato de Emergência</label>
                    <input type="tel" name="contato_emergencia" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="(99) 99999-9999">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Estado Civil</label>
                    <select name="estado_civil" class="w-full mt-1 border-gray-300 rounded-lg">
                        <option value="">Selecione</option>
                        <option value="solteiro">Solteiro(a)</option>
                        <option value="casado">Casado(a)</option>
                        <option value="divorciado">Divorciado(a)</option>
                        <option value="viuvo">Viúvo(a)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Profissão</label>
                    <input type="text" name="profissao" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Profissão">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Endereço</label>
                    <input type="text" name="endereco" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Rua, número, bairro">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Histórico Médico / Observações</label>
                <textarea name="observacoes" class="w-full mt-1 border-gray-300 rounded-lg" rows="4" placeholder="Informações importantes sobre o paciente"></textarea>
            </div>

            <button type="button" id="btnSalvarPaciente" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow">
                Salvar Paciente
            </button>
        </form>
    </div>
</div>

<!-- MODAL AGENDAMENTO -->
<div id="modalOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden flex items-center justify-center z-50">
    <div id="modalCard" class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 transform scale-95 opacity-0 transition-all">
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Novo Agendamento</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <form id="formAgendamento">
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Paciente</label>
                <select id="paciente_id" name="paciente_id" class="w-full mt-1 border-gray-300 rounded-lg">
                    <option value="">Selecione o paciente</option>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Título / Motivo</label>
                <input type="text" id="titulo" name="titulo" class="w-full mt-1 border-gray-300 rounded-lg" placeholder="Ex: Sessão de terapia" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Data</label>
                <input id="modalDate" name="data_hora_inicio" type="date" class="w-full mt-1 border-gray-300 rounded-lg" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Início</label>
                    <input id="modalStart" name="hora_inicio" type="time" class="w-full mt-1 border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Fim</label>
                    <input id="modalEnd" name="hora_fim" type="time" class="w-full mt-1 border-gray-300 rounded-lg" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-600">Observações</label>
                <textarea id="observacoes" name="observacoes" class="w-full mt-1 border-gray-300 rounded-lg" rows="3" placeholder="Informações adicionais"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600">Status</label>
                <select id="status" name="status" class="w-full mt-1 border-gray-300 rounded-lg">
                    <option value="agendada" selected>Agendada</option>
                    <option value="realizada">Realizada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>

            <button type="button" id="btnSalvarAgendamento" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow">
                Salvar Agendamento
            </button>
        </form>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/pt-br.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/pt-br.min.js"></script>

<script>
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

    pacienteModal.addEventListener("click", function(e) {
        if (e.target === pacienteModal) closePacienteModal();
    });

    /* ---------------- MODAL AGENDAAMENTO ---------------- */
    let modal = document.getElementById("modalOverlay");
    let modalCard = document.getElementById("modalCard");

    // Função para abrir modal
    window.openModal = function(info = null) {
        modal.classList.remove("hidden");

        setTimeout(() => {
            modalCard.classList.remove("scale-95", "opacity-0");
            modalCard.classList.add("scale-100", "opacity-100");
        }, 20);

        document.getElementById("modalTitle").innerText =
            info && info.event ? "Editar Agendamento" : "Novo Agendamento";

        if (info && info.start) {
            const start = moment(info.start);
            const end = moment(info.end || start.clone().add(30, "minutes"));

            document.getElementById("modalDate").value = start.format("YYYY-MM-DD");
            document.getElementById("modalStart").value = start.format("HH:mm");
            document.getElementById("modalEnd").value = end.format("HH:mm");
        }
    };

    // Função para fechar modal
    window.closeModal = function() {
        modalCard.classList.add("scale-95", "opacity-0");

        setTimeout(() => {
            modal.classList.add("hidden");
        }, 150);
    };

    // Fechar ao clicar fora
    modal.addEventListener("click", function(e) {
        if (e.target === modal) closeModal();
    });

    function closeModal() {
        document.getElementById('modalAgendamento').classList.add('hidden');
    }

    /* -------------- CALENDÁRIO -------------- */
    document.addEventListener('DOMContentLoaded', function() {

        const calendarEl = document.getElementById('calendar');
        const customHeaderEl = document.getElementById('customHeader');
        moment.locale('pt-br');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            initialView: 'timeGridWeek',
            headerToolbar: false,

            height: 'auto',
            slotMinTime: '07:00',
            slotMaxTime: '20:00',
            slotDuration: '00:30:00',
            selectable: true,
            editable: false,

            events: [], // ⚠ sem backend

            select: function(info) {
                openModal(info);
            },

            eventClick: function(info) {
                openModal(info.event);
            },

            datesSet: function(info) {
                renderHeader(info);
                updateTitle(info);
            }
        });

        calendar.render();

        /* ---- HEADER DOS DIAS ---- */
        function renderHeader(info) {
            customHeaderEl.innerHTML = "";
            const start = moment(info.start);

            for (let i = 0; i < 7; i++) {
                const day = start.clone().add(i, 'days');

                const div = document.createElement('div');
                div.className = "day-header flex-1 cursor-pointer";

                div.innerHTML = `
                <div>${day.format('ddd').toUpperCase()}</div>
                <div class="${day.isSame(moment(), 'day') ? 'day-number highlight' : 'day-number'}">
                    ${day.format('D')}
                </div>
            `;

                div.onclick = () => calendar.changeView('timeGridDay', day.format('YYYY-MM-DD'));

                customHeaderEl.appendChild(div);
            }
        }

        /* ---- TÍTULO ---- */
        function updateTitle(info) {
            const start = moment(info.start).format('D')
            const end = moment(info.end).subtract(1, 'day').format('D MMM')

            document.getElementById('title').textContent = `Semana ${start} - ${end}`;
        }

        document.getElementById('prevBtn').onclick = () => calendar.prev();
        document.getElementById('nextBtn').onclick = () => calendar.next();
        document.getElementById('todayBtn').onclick = () => calendar.today();

        document.getElementById('weekBtn').onclick = () => {
            calendar.changeView('timeGridWeek');
        };

        document.getElementById('monthBtn').onclick = () => {
            calendar.changeView('dayGridMonth');
        };

        function setActive(view) {
            const buttons = {
                dayGridMonth: 'monthBtn',
                timeGridWeek: 'weekBtn'
            };
            for (let key in buttons) {
                const btn = document.getElementById(buttons[key]);
                btn.classList.toggle('bg-blue-600', key === view);
                btn.classList.toggle('text-white', key === view);
                btn.classList.toggle('bg-gray-100', key !== view);
                btn.classList.toggle('text-gray-600', key !== view);
            }
        }

        document.getElementById('monthBtn').onclick = () => {
            calendar.changeView('dayGridMonth');
            setActive('dayGridMonth');
        };
        document.getElementById('weekBtn').onclick = () => {
            calendar.changeView('timeGridWeek');
            setActive('timeGridWeek');
        };


    });
</script>
@endpush