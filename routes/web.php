<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EvolucaoController;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas protegidas
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Agenda
    Route::get('/agenda', [ConsultaController::class, 'index'])->name('agenda.index');
    Route::get('/api/consultas', [ConsultaController::class, 'apiEvents'])->name('consultas.api');

    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
    Route::put('/consultas/{id}', [ConsultaController::class, 'update'])->name('consultas.update');
    Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');
    
    
    // Lista todos os pacientes (GET)
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    // Busca paciente específico para edição (GET JSON)
    Route::get('/pacientes/{paciente}', [PacienteController::class, 'show'])->name('pacientes.show');
    // Criação de paciente (POST)
    Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
    // Atualização de paciente (PUT)
    Route::put('/pacientes/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
    // Exclusão de paciente (DELETE)
    Route::delete('/pacientes/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');



    // Evoluções do paciente
    Route::get('/pacientes/{paciente}/evolucoes', [EvolucaoController::class, 'index'])->name('evolucoes.index');

    Route::post('/pacientes/{paciente}/evolucoes', [EvolucaoController::class, 'store'])
        ->name('evolucoes.store');

    Route::get('/evolucoes/{evolucao}/editar', [EvolucaoController::class, 'edit'])
        ->name('evolucoes.edit');

    Route::put('/evolucoes/{evolucao}', [EvolucaoController::class, 'update'])
        ->name('evolucoes.update');

    Route::delete('/evolucoes/{evolucao}', [EvolucaoController::class, 'destroy'])
        ->name('evolucoes.destroy');
});
