@extends('layouts.app')
@section('title', 'Agenda')

@push('styles')
<link href="{{ asset('css/agenda.css') }}" rel="stylesheet">
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

@include('agenda.modals')
@endsection



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/pt-br.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/pt-br.min.js"></script>
<script src="/js/calendar.js"></script>
<script src="/js/modal-agendamento.js"></script>
<script src="/js/modal-paciente.js"></script>
<script src="/js/agenda-crud.js"></script>
<script src="/js/header-navegacao.js"></script>
@endpush
