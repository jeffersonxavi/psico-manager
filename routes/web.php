<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EvolucaoController;
use App\Http\Controllers\SessaoController;
use App\Http\Controllers\RegistroController;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});
// Rotas protegidas por autenticação
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Agenda de consultas
    Route::get('/agenda', [ConsultaController::class, 'index'])->name('agenda.index');
    Route::get('/api/consultas', [ConsultaController::class, 'apiEvents'])->name('consultas.api');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
    Route::put('/consultas/{id}', [ConsultaController::class, 'update'])->name('consultas.update');
    Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');

    // Rotas de pacientes
    Route::prefix('pacientes')->group(function () {
        Route::get('/', [PacienteController::class, 'index'])->name('pacientes.index');
        Route::get('/{paciente}', [PacienteController::class, 'show'])->name('pacientes.show');
        Route::post('/', [PacienteController::class, 'store'])->name('pacientes.store');
        Route::put('/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
        Route::delete('/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');

        // Sessões dentro de paciente
        Route::get('{paciente}/sessoes', [SessaoController::class, 'index'])->name('prontuario.index');
        Route::post('{paciente}/sessoes', [SessaoController::class, 'store'])->name('sessoes.store');

           // REGISTROS — AGORA COM SESSAO!
    Route::prefix('{paciente}/sessoes/{sessao}/registros')->group(function () {

        Route::post('/', [RegistroController::class, 'store'])->name('registros.store');
        Route::get('{registro}/edit', [RegistroController::class, 'edit'])->name('registros.edit');
        Route::put('{registro}', [RegistroController::class, 'update'])->name('registros.update');
        Route::delete('{registro}', [RegistroController::class, 'destroy'])->name('registros.destroy');

    });
    });

    // Sessões individuais (edit/update/delete)
    Route::get('sessoes/{sessao}/edit', [SessaoController::class, 'edit'])->name('sessoes.edit');
    Route::put('sessoes/{sessao}', [SessaoController::class, 'update'])->name('sessoes.update');
    Route::delete('sessoes/{sessao}', [SessaoController::class, 'destroy'])->name('sessoes.destroy');

    // Registros individuais (edit/update/delete)
    Route::get('registros/{registro}/edit', [RegistroController::class, 'edit'])->name('registros.edit');
    Route::put('registros/{registro}', [RegistroController::class, 'update'])->name('registros.update');
    Route::delete('registros/{registro}', [RegistroController::class, 'destroy'])->name('registros.destroy');

    // Iniciar atendimento
    Route::get('/consultas/{consulta}/iniciar-atendimento', [ConsultaController::class, 'iniciarAtendimento'])
        ->name('consultas.iniciar-atendimento');
// Adicione isso logo abaixo da rota da agenda
Route::get('/consultas', function () {
    return redirect()->route('agenda.index');
})->name('consultas.index');

});
