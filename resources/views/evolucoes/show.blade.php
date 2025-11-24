@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold">{{ ucfirst($evolucao->tipo) }}</h1>
<p class="text-gray-600">Registrado em {{ $evolucao->created_at->format('d/m/Y H:i') }}</p>

<div class="mt-4 p-4 border rounded bg-gray-50">
    {!! nl2br(e($evolucao->conteudo)) !!}
</div>

<div class="mt-4 flex gap-3">
    <a href="{{ route('evolucoes.edit', $evolucao) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Editar</a>

    <form method="POST" action="{{ route('evolucoes.destroy', $evolucao) }}">
        @csrf @method('DELETE')
        <button class="px-4 py-2 bg-red-600 text-white rounded">Excluir</button>
    </form>
</div>
@endsection
