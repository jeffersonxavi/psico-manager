<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Sessao;

class SessaoController extends Controller
{
    // Listar todas as sessões de um paciente
    public function index(Paciente $paciente)
    {
        $sessoes = $paciente->sessoes()
            ->with('registros.profissional')
            // ALTERADO: Ordenar de forma DECRESCENTE (da mais recente para a mais antiga)
            ->orderBy('data_sessao', 'desc')
            ->get();

        return view('prontuario.index', compact('paciente', 'sessoes'));
    }


    public function create(Paciente $paciente)
    {
        $dataSessao = session('data_sessao', now());

        return view('sessoes.create', compact('paciente', 'dataSessao'));
    }
    
    /**
     * Busca uma sessão baseada no ID da consulta.
     * Retorna dados em JSON, incluindo paciente, profissional e registros.
     *
     * @param int $consultaId - ID da consulta
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarPorConsulta($consultaId)
    {
        // Busca a sessão relacionada à consulta, incluindo paciente, profissional e registros
        $sessao = \App\Models\Sessao::with(['paciente', 'profissional', 'registros.profissional'])
            ->where('consulta_id', $consultaId)
            ->first();

        // Se não encontrar, retorna 404
        if (!$sessao) {
            return response()->json(null, 404);
        }

        // Retorna os dados da sessão em formato JSON
        return response()->json([
            'id' => $sessao->id,
            'data_sessao' => $sessao->data_sessao?->format('d/m/Y H:i') ?? '-', // data formatada ou '-'
            'conteudo' => $sessao->conteudo ?? '',
            'paciente_nome' => $sessao->paciente?->nome ?? '-', // nome do paciente ou '-'
            'profissional_nome' => $sessao->profissional?->name ?? '-', // nome do profissional ou '-'
            'registros' => $sessao->registros->map(fn($r) => [
                'id' => $r->id,
                'tipo' => $r->tipo,
                'conteudo' => $r->conteudo ?? '',
                'created_at' => $r->created_at?->format('d/m/Y H:i') ?? '-',
                'usuario_nome' => $r->profissional?->name ?? 'Usuário Desconhecido', // nome do profissional que registrou ou fallback
            ]),
        ]);
    }


 public function store(Request $request, Paciente $paciente)
{
    $request->validate([
        'data_sessao' => 'required|date',
        'conteudo'    => 'required|string',
    ]);

    $sessao = $paciente->sessoes()->create([
        'profissional_id' => auth()->id(),
        'data_sessao'     => $request->data_sessao,
        'conteudo'        => $request->conteudo,
        'consulta_id'     => $request->consulta_id ?? null,
    ]);

    $mensagem = 'Sessão registrada com sucesso!';

    // Só atualiza o status e adiciona parte da mensagem se tiver consulta vinculada
    if ($request->filled('consulta_id')) {
        Consulta::where('id', $request->consulta_id)
                ->update(['status' => 'atendido']);

        $mensagem .= ' Consulta marcada como atendida.';
    }

    // Redireciona para o prontuário. Se a ordem foi alterada para ASC,
    // o usuário verá a nova sessão no final da lista.
    return redirect()
        ->route('prontuario.index', $paciente)
        ->with('success', $mensagem);
}

    public function edit(Sessao $sessao)
    {
        return view('sessoes.edit', compact('sessao'));
    }


    public function update(Request $request, Sessao $sessao)
    {
        $request->validate([
            'data_sessao' => 'required|date',
            'conteudo' => 'nullable|string',
        ]);

        // Atualiza a sessão
        $sessao->update([
            'data_sessao' => $request->data_sessao,
            'conteudo' => $request->conteudo,
        ]);

        // 🔥 Atualiza a consulta vinculada (se existir)
        if ($sessao->consulta_id) {
            $consulta = Consulta::find($sessao->consulta_id);

            if ($consulta) {
                $consulta->update([
                    'data_hora_inicio' => $request->data_sessao,
                    'data_hora_fim' => \Carbon\Carbon::parse($request->data_sessao)->addHour(), // opcional
                    'paciente_id' => $sessao->paciente_id, // mantém paciente sincronizado
                ]);
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Sessão atualizada com sucesso!');
    }

    public function destroy(Sessao $sessao)
    {
        $sessao->delete();
        return redirect()->back()->with('success', 'Sessão excluída com sucesso!');
    }
}