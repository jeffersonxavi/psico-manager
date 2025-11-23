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
            'agendado'    => ['bg' => '#e2e8f0', 'border' => '#94a3b8', 'text' => '#1f2937'], // Cinza muito suave
            'confirmado'  => ['bg' => '#bae6fd', 'border' => '#38bdf8', 'text' => '#0c4a6b'], // Azul
            'atendido'    => ['bg' => '#a7f3d0', 'border' => '#34d399', 'text' => '#065f46'], // Verde
            'faltou'      => ['bg' => '#fcd34d', 'border' => '#f59e0b', 'text' => '#713f12'], // Amarelo
            'desmarcado'  => ['bg' => '#fecaca', 'border' => '#f87171', 'text' => '#7f1d1d'], // Vermelho
        ];
        
        $events = $consultas->map(function ($c) use ($cores) {

            // Seleciona a cor do status ou a cor padrão caso não exista
            $cor = $cores[$c->status] ?? $cores['agendado'];

            return [
                'id'    => $c->id,
                'title' => $c->paciente->nome . ' - ' . $c->titulo,
                'start' => $c->data_hora_inicio->format('Y-m-d\TH:i:s'),
                'end'   => $c->data_hora_fim->format('Y-m-d\TH:i:s'),

                // Cores do evento: Usando as cores ajustadas para melhor contraste
                'backgroundColor' => $cor['bg'],
                'borderColor'     => $cor['border'],
                'textColor'       => $cor['text'], // Usa a cor de texto definida na paleta

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
   
}
