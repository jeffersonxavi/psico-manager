@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Nova Evolução</h1>

<form method="POST" action="{{ route('evolucoes.store') }}">
    @csrf

    <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">
    <input type="hidden" name="consulta_id" value="{{ $consulta->id ?? '' }}">

    <label class="block mb-2">Tipo</label>
    <select name="tipo" class="border p-2 rounded w-full mb-4">
        @foreach($tipos as $tipo)
            <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Conteúdo</label>
    <textarea name="conteudo" rows="8" class="border p-2 rounded w-full mb-4"></textarea>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
</form>
@endsection
