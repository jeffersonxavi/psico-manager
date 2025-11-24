<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    use AuthorizesRequests; 
    public function index()
    {
        $pacientes = Paciente::where('profissional_id', Auth::id())->get();
        return view('pacientes.index', compact('pacientes'));
    }

   public function store(Request $request)
{
    $data = $request->validate([
        'id' => 'nullable|integer|exists:pacientes,id', // para identificar edição
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

    // updateOrCreate → se tiver ID, atualiza; senão cria
    $paciente = Paciente::updateOrCreate(
        ['id' => $data['id'] ?? null],
        $data
    );

    return response()->json([
        'success' => true,
        'message' => $request->id ? 'Paciente atualizado!' : 'Paciente criado!',
        'paciente' => $paciente
    ]);
}
public function show(Paciente $paciente)
{
    return response()->json($paciente);
}


    public function edit(Paciente $paciente)
    {
        $this->authorize('update', $paciente);
        return view('pacientes.edit', compact('paciente'));
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
