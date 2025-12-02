@extends('layouts.app')
@section('pageTitle', 'Pacientes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Meus Pacientes</h1>
        <button onclick="openPacienteModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg shadow-md transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Novo Paciente
        </button>
    </div>

    <!-- Tabela Responsiva -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Paciente</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden sm:table-cell">Telefone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">E-mail</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pacientes as $paciente)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-5 font-medium text-gray-900">
                            {{ $paciente->nome }}
                        </td>
                        <td class="px-6 py-5 text-gray-600 hidden sm:table-cell">
                            {{ $paciente->telefone ?? '—' }}
                        </td>
                        <td class="px-6 py-5 text-gray-600 hidden md:table-cell">
                            {{ $paciente->email ?? '—' }}
                        </td>
                        <td class="px-6 py-5 text-center text-sm">
                            <div class="flex items-center justify-center gap-3 flex-wrap">
                                <button onclick="editPaciente({{ $paciente->id }})"
                                        class="text-indigo-600 hover:text-indigo-800 font-medium transition">
                                    Editar
                                </button>
                                <button onclick="deletePaciente({{ $paciente->id }}, '{{ addslashes($paciente->nome) }}')"
                                        class="text-red-600 hover:text-red-800 font-medium transition">
                                    Excluir
                                </button>
                                <a href="{{ route('prontuario.index', $paciente->id) }}"
                                   class="text-green-600 hover:text-green-800 font-medium transition">
                                    Sessões
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-lg">Nenhum paciente cadastrado ainda.</p>
                                <button onclick="openPacienteModal()" class="mt-3 text-indigo-600 hover:underline">
                                    Clique aqui para adicionar o primeiro
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('pacientes.create')
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let pacienteId = null;

    window.openPacienteModal = function() {
        pacienteId = null;
        document.getElementById('pacienteForm').reset();
        document.getElementById('modalTitle').textContent = 'Novo Paciente';
        document.getElementById('pacienteModal').classList.remove('hidden');
    };
    window.deletePaciente = function(id, nome) {
        Swal.fire({
            title: 'Excluir paciente?',
            text: `"${nome}" será removido permanentemente.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/pacientes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        Swal.fire('Excluído!', res.message, 'success').then(() => location.reload());
                    }
                })
                .catch(() => Swal.fire('Erro', 'Não foi possível excluir.', 'error'));
            }
        });
    };

    // Submissão do formulário (create/update)
    document.getElementById('pacienteForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (pacienteId) formData.append('id', pacienteId);

        fetch('{{ route("pacientes.store") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pronto!',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            }
        })
        .catch(() => {
            Swal.fire('Erro', 'Verifique os dados e tente novamente.', 'error');
        });
    });
</script>
@endpush