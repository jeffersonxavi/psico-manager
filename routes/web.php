<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\PacienteController;

/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
*/

// Rota principal
Route::get('/', function () {
    return view('welcome');
});

// Rotas da agenda (sem middleware 'auth')
Route::get('/agenda', [ConsultaController::class, 'index'])->name('agenda.index');
Route::get('/api/consultas', [ConsultaController::class, 'apiEvents'])->name('consultas.api');

Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
Route::put('/consultas/{id}', [ConsultaController::class, 'update'])->name('consultas.update');
Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');

// Rotas de pacientes
Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
Route::post('/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
Route::put('/pacientes/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
Route::delete('/pacientes/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');
