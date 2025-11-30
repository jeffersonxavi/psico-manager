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
            ->orderBy('data_sessao', 'desc')
            ->get();

        return view('prontuario.index', compact('paciente', 'sessoes'));
    }


    public function create(Paciente $paciente)
    {
        $dataSessao = session('data_sessao', now());

        return view('sessoes.create', compact('paciente', 'dataSessao'));
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

        $sessao->update([
            'data_sessao' => $request->data_sessao,
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->back()->with('success', 'Sessão atualizada com sucesso!');
    }

    public function destroy(Sessao $sessao)
    {
        $sessao->delete();
        return redirect()->back()->with('success', 'Sessão excluída com sucesso!');
    }
}
