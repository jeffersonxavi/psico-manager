<?php

namespace App\Http\Controllers;

use App\Models\Evolucao;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvolucaoController extends Controller
{
    public function index(Paciente $paciente)
    {
        $evolucoes = Evolucao::where('paciente_id', $paciente->id)
            ->orderBy('data_registro', 'desc')
            ->get();

        return view('evolucoes.index', compact('paciente', 'evolucoes'));
    }

    public function store(Request $request, Paciente $paciente)
    {
        $validated = $request->validate([
            'conteudo' => 'required|string',
            'tipo' => 'required|in:evolucao,interconsulta,anotacao,feedback',
            'data_registro' => 'nullable|date',
        ]);

        Evolucao::create([
            'paciente_id' => $paciente->id,
            'consulta_id' => $request->consulta_id,
            'profissional_id' => Auth::id(),
            'tipo' => $validated['tipo'],
            'conteudo' => $validated['conteudo'],
            'data_registro' => $validated['data_registro'] ?? now(),
        ]);

        return back()->with('success', 'Evolução registrada com sucesso.');
    }

    public function edit(Evolucao $evolucao)
    {
        return view('evolucoes.edit', compact('evolucao'));
    }

    public function update(Request $request, Evolucao $evolucao)
    {
        $validated = $request->validate([
            'conteudo' => 'required|string',
            'tipo' => 'required|in:evolucao,interconsulta,anotacao,feedback',
            'data_registro' => 'nullable|date',
        ]);

        $evolucao->update($validated);

        return redirect()
            ->route('evolucoes.index', $evolucao->paciente_id)
            ->with('success', 'Evolução atualizada com sucesso.');
    }

    public function destroy(Evolucao $evolucao)
    {
        $paciente_id = $evolucao->paciente_id;
        $evolucao->delete();

        return redirect()
            ->route('evolucoes.index', $paciente_id)
            ->with('success', 'Evolução removida.');
    }
}
