{{-- resources/views/registros/partials/registro-item.blade.php (Compacto) --}}
<div x-data 
    class="group relative bg-white border border-gray-100 rounded-xl p-4 {{-- Padding reduzido --}}
           shadow-sm hover:shadow-md hover:border-blue-200 hover:bg-white transition-all duration-300">
    
    <div class="flex items-start justify-between gap-4">
        
        {{-- ## Conteúdo --}}
        <div class="flex-1 min-w-0">
            
       {{-- Tipo e Metadata (Ultra Compacto e Clean) --}}
        <div class="flex items-center gap-2"> {{-- Redução do gap de 3 para 2, remoção do mb-2 --}}
            
            {{-- Ícone e Cor (Mais discretos) --}}
            <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center {{-- Tamanho reduzido (w-6 h-6) --}}
                @switch($registro->tipo)
                    @case('evolucao') bg-blue-50 text-blue-600 @break
                    @case('anotacao') bg-amber-50 text-amber-600 @break
                    @case('interconsulta') bg-purple-50 text-purple-600 @break
                    @case('feedback') bg-green-50 text-green-600 @break
                    @default bg-gray-50 text-gray-600
                @endswitch">
                {{-- Atenção: O ícone deve ser injetado aqui via Blade ou função Alpine que retorna o SVG --}}
                <span x-html="iconeTipo()" class="w-3 h-3"></span> {{-- Ícone menor para caber --}}
            </div>
            
            {{-- Título e Data/Profissional (Em uma única linha de texto) --}}
            <p class="text-xs text-gray-700 tracking-tight">
                
                {{-- Tipo (Forte e uppercase) --}}
                <span class="font-bold uppercase">
                    {{ str_replace('_', ' ', $registro->tipo) }}
                </span>
                
                {{-- Separador e Metadata (Mais suave) --}}
                <span class="text-gray-500 font-medium ml-1">
                    • {{ $registro->data_registro->translatedFormat('d/m \à\s H:i') }}
                    
                    {{-- Profissional (Só se for diferente do logado, ou remover se for sempre o mesmo profissional na tela) --}}
                    @if(Auth::user()->id !== $registro->profissional_id)
                        <span class="text-gray-400 font-normal hidden sm:inline"> | {{ $registro->profissional->name }}</span>
                    @endif
                </span>
            </p>
        </div>

            {{-- Texto do registro --}}
            <p class="text-gray-700 leading-snug whitespace-pre-line text-sm border-l-2 border-gray-100 pl-3 py-0.5"> {{-- Padding e line-height reduzidos --}}
                {!! nl2br(e($registro->conteudo)) !!}
            </p>
        </div   >

        {{-- ## Ações --}}
        <div class="flex flex-shrink-0 items-center gap-1 opacity-50 group-hover:opacity-100 transition-opacity duration-200">
            
            {{-- Botão Excluir --}}
            <form action="{{ route('registros.destroy', [$sessao->paciente_id, $sessao->id, $registro->id]) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Excluir este registro?')"
                    class="p-1.5 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition" {{-- Padding e botão reduzidos --}}
                    title="Excluir Registro">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2.375 2.375 0 0116.138 21H7.862a2.375 2.375 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
            
            {{-- Botão Editar (Manter desativado para compactação máxima) --}}
        </div>
    </div>

    {{-- Função Alpine que gera o ícone correto (Manter o script, pois é necessário para renderizar o ícone) --}}
    <script>
        function iconeTipo() {
            const tipo = @json($registro->tipo);
            // Mantendo os SVGs originais, pois se adaptam ao tamanho 4x4.
            const icones = {
                evolucao: `<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>`,
                anotacao: `<svg fill="currentColor" viewBox="0 0 24 24"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM5 15l4 4 2.5-2.5L14 19l6-6V5H3v10h2z"/></svg>`,
                interconsulta: `<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.44 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.19-2.83l1.17-1.19c.4-.4.64-.94.64-1.55 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.76-1.07 2.31z"/></svg>`,
                feedback: `<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.5-10.5l-5.5 5.5-2.5-2.5 1.41-1.41L11 14.09l4.09-4.09 1.41 1.41z"/></svg>`,
            };
            return icones[tipo] || '';
        }
    </script>
</div>