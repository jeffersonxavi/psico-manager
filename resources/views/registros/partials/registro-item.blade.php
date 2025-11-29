{{-- resources/views/registros/partials/registro-item.blade.php --}}
<div x-data class="group relative bg-white border border-gray-200 rounded-2xl p-6 hover:border-gray-300 hover:shadow-md transition-all duration-300">
    <div class="flex items-start justify-between gap-5">
        <!-- Conteúdo -->
        <div class="flex-1">
            <!-- Tipo com ícone -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                    @switch($registro->tipo)
                        @case('evolucao') bg-blue-100 text-blue-600 @break
                        @case('anotacao') bg-amber-100 text-amber-600 @break
                        @case('interconsulta') bg-purple-100 text-purple-600 @break
                        @case('feedback') bg-green-100 text-green-600 @break
                        @default bg-gray-100 text-gray-600
                    @endswitch">
                    <span x-html="iconeTipo()" class="w-5 h-5"></span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">
                        {{ ucfirst(str_replace('_', ' ', $registro->tipo)) }}
                    </h4>
                    <p class="text-xs text-gray-500">
                        {{ $registro->data_registro->diffForHumans() }} • {{ $registro->profissional->name }}
                    </p>
                </div>
            </div>

            <!-- Texto do registro -->
            <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                {!! nl2br(e($registro->conteudo)) !!}
            </p>
        </div>

        <!-- Ações -->
        <div class="flex items-center gap-2 opacity-70 group-hover:opacity-100 transition-opacity">
           <!-- <a href="{{ route('registros.edit', [$sessao->paciente_id, $sessao->id, $registro->id]) }}"
                class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </a> -->

            <form action="{{ route('registros.destroy', [$sessao->paciente_id, $sessao->id, $registro->id]) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Excluir este registro?')"
                    class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.375 2.375 0 0116.138 21H7.862a2.375 2.375 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Função Alpine que gera o ícone correto -->
    <script>
        function iconeTipo() {
            const tipo = @json($registro->tipo);
            const icones = {
                evolucao: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                anotacao: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h16v12H5.17L4 18.83V4m5-2h6a2 2 0 012 2v10a2 2 0 01-2 2H9l-4 4v-4H5a2 2 0 01-2-2V6a2 2 0 012-2h4z"/></svg>`,
                interconsulta: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a1 1 0 100 2 3 3 0 013 3 1 1 0 102 0 5 5 0 00-5-5zm0 8a1 1 0 100 2 1 1 0 000-2z"/></svg>`,
                feedback: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 10-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L10 10.586 8.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>`,
            };
            return icones[tipo] || '';
        }
    </script>
</div>