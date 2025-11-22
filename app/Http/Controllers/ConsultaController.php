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
        return view('agenda.index', compact('pacientes'));
    }

    /**
     * API para FullCalendar.
     */
    public function apiEvents(Request $request)
    {
        $profissionalId = Auth::id();

        $start = \Carbon\Carbon::parse($request->start)->startOfDay();
        $end   = \Carbon\Carbon::parse($request->end)->endOfDay();

        $consultas = Consulta::with('paciente')
            ->where('profissional_id', $profissionalId)
            ->whereBetween('data_hora_inicio', [$start, $end])
            ->get();

        // Cores exatas conforme o <select>
        $cores = [
            'agendado'   => ['bg' => '#6b7280', 'border' => '#4b5563'], // cinza
            'confirmado' => ['bg' => '#06b6d4', 'border' => '#0891b2'], // azul água
            'atendido'   => ['bg' => '#16a34a', 'border' => '#15803d'], // verde
            'faltou'     => ['bg' => '#eab308', 'border' => '#ca8a04'], // amarelo
            'desmarcado' => ['bg' => '#dc2626', 'border' => '#b91c1c'], // vermelho
        ];

        $events = $consultas->map(function ($c) use ($cores) {

            // Seleciona a cor do status ou cinza caso não exista
            $cor = $cores[$c->status] ?? $cores['agendado'];

            return [
                'id'    => $c->id,
                'title' => $c->paciente->nome . ' - ' . $c->titulo,
                'start' => $c->data_hora_inicio->format('Y-m-d\TH:i:s'),
                'end'   => $c->data_hora_fim->format('Y-m-d\TH:i:s'),

                // Cores do evento
                'backgroundColor' => $cor['bg'],
                'borderColor'     => $cor['border'],
                'textColor'       => '#ffffff',

                // Dados extras úteis
                'extendedProps' => [
                    'status' => $c->status,
                    'paciente_id' => $c->paciente_id,
                    'titulo' => $c->titulo,
                ],
            ];
        });

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
            'status' => 'nullable|in:agendado,confirmado,atendido,faltou,desmarcado',
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
            'status' => 'nullable|in:agendado,confirmado,atendido,faltou,desmarcado',
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
    protected function formatEvent(Consulta $consulta)
    {
        // Cores exatamente iguais ao seu select
        $colors = [
            'agendado'   => ['bg' => '#6b7280', 'border' => '#4b5563'], // gray-500 / gray-600
            'confirmado' => ['bg' => '#06b6d4', 'border' => '#0891b2'], // cyan-500 / cyan-600
            'atendido'   => ['bg' => '#16a34a', 'border' => '#15803d'], // green-600 / green-700
            'faltou'     => ['bg' => '#eab308', 'border' => '#ca8a04'], // yellow-500 / yellow-600
            'desmarcado' => ['bg' => '#dc2626', 'border' => '#b91c1c'], // red-600 / red-700
        ];

        $color = $colors[$consulta->status] ?? ['bg' => '#6b7280', 'border' => '#4b5563']; // fallback cinza

        return [
            'id' => $consulta->id,
            'title' => $consulta->paciente->nome . ' - ' . $consulta->titulo,
            'start' => $consulta->data_hora_inicio->format('Y-m-d\TH:i:s'),
            'end'   => $consulta->data_hora_fim->format('Y-m-d\TH:i:s'),
            'backgroundColor' => $color['bg'],
            'borderColor'     => $color['border'],
            'textColor'       => '#ffffff',
            'extendedProps' => [
                'paciente_id' => $consulta->paciente_id,
                'titulo'      => $consulta->titulo,
                'status'      => $consulta->status,
            ],
        ];
    }
}
