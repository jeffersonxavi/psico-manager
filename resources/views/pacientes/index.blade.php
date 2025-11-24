@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Pacientes</h1>

    <button onclick="openPacienteModal()" class="bg-blue-500 text-white px-4 py-2 rounded-xl mb-6 hover:bg-blue-600 transition">Novo Paciente</button>

    <table class="w-full border rounded-xl shadow-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 text-left">Nome</th>
                <th class="p-3 text-left">Telefone</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $paciente)
            <tr class="border-t">
                <td class="p-3">{{ $paciente->nome }}</td>
                <td class="p-3">{{ $paciente->telefone }}</td>
                <td class="p-3">{{ $paciente->email }}</td>
                <td class="p-3 flex gap-2">
                    <a href="javascript:void(0)" onclick="editPaciente({{ $paciente->id }})" class="text-blue-500 hover:underline">Editar</a>
                    <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('pacientes.create')
@endsection

@push('scripts')
@endpush