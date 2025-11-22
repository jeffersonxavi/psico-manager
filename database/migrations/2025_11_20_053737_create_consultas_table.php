<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profissional_id');
            $table->unsignedBigInteger('paciente_id');
            $table->string('titulo');
            $table->dateTime('data_hora_inicio');
            $table->dateTime('data_hora_fim');
            $table->text('observacoes')->nullable();
            // Status da consulta
            $table->enum('status', ['agendado', 'confirmado', 'atendido', 'faltou', 'desmarcado'])
                  ->default('agendado');
            $table->timestamps();

            $table->foreign('profissional_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
