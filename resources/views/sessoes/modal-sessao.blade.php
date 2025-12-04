<!-- Modal Visualizar Atendimento -->
<div id="modalVisualizarOverlay"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden flex items-center justify-center z-[70] transition-opacity duration-200">

    <div id="modalVisualizarCard"
         class="bg-white w-full max-w-4xl rounded-xl shadow-xl p-6
                border border-gray-200 transform scale-95 opacity-0 transition-all duration-200
                max-h-[85vh] overflow-y-auto">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 id="modalVisualizarTitulo" class="text-3xl font-extrabold text-indigo-800 flex items-center gap-2">
                <i class="fas fa-notes-medical"></i> Atendimento
            </h1>
            <button onclick="closeVisualizarModal()"
                    class="text-gray-400 hover:text-red-500 text-xl transition leading-none">
                &times;
            </button>
        </div>

        <!-- Detalhes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
            <div>
                <p class="font-semibold text-indigo-700">Data e Hora:</p>
                <p id="modalVisualizarData" class="text-gray-700">
                    <i class="far fa-calendar-alt mr-1"></i> -
                </p>
            </div>
            <div>
                <p class="font-semibold text-indigo-700">Profissional:</p>
                <p id="modalVisualizarProfissional" class="text-gray-700">
                    <i class="far fa-user-circle mr-1"></i> -
                </p>
            </div>
        </div>

        <!-- Conteúdo da Sessão -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-3 border-b pb-2 flex items-center">
                <i class="fas fa-file-alt mr-2 text-indigo-600"></i> Conteúdo da Sessão
            </h2>
            <div id="modalVisualizarConteudo"
                 class="prose prose-lg max-w-none text-gray-700 p-4 border border-gray-200 rounded-lg bg-gray-50 leading-relaxed">
                Nenhum conteúdo registrado.
            </div>
        </div>

        <!-- Registros -->
        <div class="border-t pt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-clipboard-list mr-2 text-indigo-600"></i> Registros de Anotações
            </h2>
            <div id="modalVisualizarRegistros" class="space-y-4">
                <p class="text-gray-500 italic">Nenhum registro de anotação adicional encontrado.</p>
            </div>
        </div>
    </div>
</div>
