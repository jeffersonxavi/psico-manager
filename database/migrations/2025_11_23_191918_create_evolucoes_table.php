<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('evolucoes', function (Blueprint $table) {
            $table->id();

            // 🔗 quem é o paciente
            $table->foreignId('paciente_id')
                ->constrained()
                ->cascadeOnDelete();
            // 🔗 pode ou não ter consulta vinculada
            $table->foreignId('consulta_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            // 🔗 profissional que escreveu a evolução
            $table->foreignId('profissional_id')
                ->constrained('users')
                ->cascadeOnDelete();
            // 📝 conteúdo da evolução
            $table->enum('tipo', [
                'evolucao',
                'interconsulta',
                'anotacao',
                'feedback'
            ])->default('evolucao');;

            $table->longText('conteudo');
            
            // 🕒 data da evolução (permite retroativa)
            $table->timestamp('data_registro')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('evolucoes');
    }
};
