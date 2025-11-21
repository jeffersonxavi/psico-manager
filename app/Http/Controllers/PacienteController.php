<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::where('profissional_id', Auth::id())->get();
        return view('pacientes.index', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'data_nascimento' => 'nullable|date',
            'contato_emergencia' => 'nullable|string|max:100',
            'estado_civil' => 'nullable|string|max:50',
            'profissao' => 'nullable|string|max:100',
            'endereco' => 'nullable|string|max:150',
            'observacoes' => 'nullable|string'
        ]);

        $data['profissional_id'] = Auth::id();

        Paciente::create($data);

        return response()->json(['success' => true, 'message' => 'Paciente criado!']);
    }

    public function update(Request $request, Paciente $paciente)
    {
        $this->authorize('update', $paciente); // opcional, política

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'data_nascimento' => 'nullable|date',
            'contato_emergencia' => 'nullable|string|max:100',
            'estado_civil' => 'nullable|string|max:50',
            'profissao' => 'nullable|string|max:100',
            'endereco' => 'nullable|string|max:150',
            'observacoes' => 'nullable|string'
        ]);

        $paciente->update($data);

        return response()->json(['success' => true, 'message' => 'Paciente atualizado!']);
    }

    public function destroy(Paciente $paciente)
    {
        $this->authorize('delete', $paciente);

        $paciente->delete();
        return response()->json(['success' => true, 'message' => 'Paciente removido!']);
    }
}
