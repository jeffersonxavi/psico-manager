<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ConsultaController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::where('profissional_id', Auth::id())->get(['id', 'nome']);
return view('agenda.index', compact('pacientes'));    }

    /**
     * API para FullCalendar.
     */
    public function apiEvents(Request $request)
    {
        $profissionalId = Auth::id();
        $start = $request->get('start');
        $end = $request->get('end');

        $consultas = Consulta::with('paciente')
            ->where('profissional_id', $profissionalId)
            ->whereBetween('data_hora_inicio', [$start, $end])
            ->get();

        $events = [];
        foreach ($consultas as $consulta) {
            $events[] = [
                'id' => $consulta->id,
                'title' => $consulta->paciente->nome . ' - ' . $consulta->titulo,
                'start' => $consulta->data_hora_inicio->toISOString(),
                'end' => $consulta->data_hora_fim->toISOString(),
                'backgroundColor' => '#2563eb',
                'borderColor' => '#1d4ed8',
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'paciente_id' => $consulta->paciente_id,
                    'titulo' => $consulta->titulo,
                    'observacoes' => $consulta->observacoes,
                    'status' => $consulta->status,
                ],
            ];
        }

        return response()->json($events);
    }

    /**
     * Cria uma nova consulta.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'paciente_id' => ['required', 'exists:pacientes,id', Rule::exists('pacientes', 'id')->where('profissional_id', Auth::id())],
            'titulo' => 'required|string|max:255',
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
            'observacoes' => 'nullable|string',
            'status' => 'nullable|in:agendada,realizada,cancelada',
        ]);

        $data['profissional_id'] = Auth::id();
        $data['status'] = $data['status'] ?? 'agendada';

        $consulta = Consulta::create($data);

        return response()->json(['success' => true, 'consulta' => $consulta, 'message' => 'Consulta agendada com sucesso!'], 201);
    }

    /**
     * Atualiza uma consulta existente.
     */
    public function update(Request $request, $id)
    {
        $consulta = Consulta::where('id', $id)
            ->where('profissional_id', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'paciente_id' => ['required', 'exists:pacientes,id', Rule::exists('pacientes', 'id')->where('profissional_id', Auth::id())],
            'titulo' => 'required|string|max:255',
            'data_hora_inicio' => 'required|date',
            'data_hora_fim' => 'required|date|after:data_hora_inicio',
            'observacoes' => 'nullable|string',
            'status' => 'nullable|in:agendada,realizada,cancelada',
        ]);

        $consulta->update($data);

        return response()->json(['success' => true, 'consulta' => $consulta, 'message' => 'Consulta atualizada com sucesso!'], 200);
    }

    /**
     * Deleta (cancela) uma consulta.
     */
    public function destroy($id)
    {
        $consulta = Consulta::where('id', $id)
            ->where('profissional_id', Auth::id())
            ->firstOrFail();

        $consulta->delete();

        return response()->json(['success' => true, 'message' => 'Consulta excluída com sucesso!'], 200);
    }

    /**
     * Converte os dados do modelo Consulta para o formato FullCalendar.
     * @param \Illuminate\Support\Collection $consultas
     * @return array
     */
    protected function formatEventsForFullCalendar($consultas)
    {
        $events = [];
        foreach ($consultas as $consulta) {
            // O título do evento no calendário será o nome do paciente + título da consulta
            $title = $consulta->paciente->nome . ' - ' . $consulta->titulo;

            $events[] = [
                'id' => $consulta->id,
                'title' => $title,
                'start' => $consulta->data_hora_inicio->toISOString(),
                'end' => $consulta->data_hora_fim->toISOString(),
                // Configurações visuais (pode variar por status)
                'backgroundColor' => '#2563eb', // Tailwind blue-600 (Primary)
                'borderColor' => '#1d4ed8',
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'paciente_id' => $consulta->paciente_id,
                    'titulo' => $consulta->titulo,
                    'status' => $consulta->status,
                ],
            ];
        }
        return $events;
    }
}
