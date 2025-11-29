<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Paciente;
use App\Models\Sessao;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    /**
     * Criar novo registro dentro de uma sessão
     */
    public function store(Request $request, Paciente $paciente, Sessao $sessao)
    {
        $request->validate([
            'tipo'          => 'required|in:evolucao,anotacao,feedback,interconsulta',
            'conteudo'      => 'required|string',
            'data_registro' => 'nullable|date',
        ]);

        Registro::create([
            'paciente_id'     => $paciente->id,
            'sessao_id'       => $sessao->id,
            'profissional_id' => Auth::id(),
            'tipo'            => $request->tipo,
            'conteudo'        => $request->conteudo,
            'data_registro'   => $request->data_registro ?? now(),
        ]);

        return redirect()
            ->route('prontuario.index', $paciente->id)
            ->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Formulário de edição
     */
    public function edit(Paciente $paciente, Sessao $sessao, Registro $registro)
    {
        return view('registros.edit', compact('paciente', 'sessao', 'registro'));
    }

    /**
     * Atualizar o registro
     */
    public function update(Request $request, Paciente $paciente, Sessao $sessao, Registro $registro)
    {
        $request->validate([
            'tipo'          => 'required|in:evolucao,anotacao,feedback,interconsulta',
            'conteudo'      => 'required|string',
            'data_registro' => 'nullable|date',
        ]);

        $registro->update([
            'tipo'          => $request->tipo,
            'conteudo'      => $request->conteudo,
            'data_registro' => $request->data_registro ?? now(),
        ]);

        return redirect()
            ->route('prontuario.index', $paciente->id)
            ->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Deletar registro
     */
    public function destroy(Paciente $paciente, Sessao $sessao, Registro $registro)
    {
        $registro->delete();

        return redirect()
            ->route('prontuario.index', $paciente->id)
            ->with('success', 'Registro excluído com sucesso!');
    }
}
