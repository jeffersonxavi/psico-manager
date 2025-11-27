<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Paciente;
use App\Models\Consulta;
use App\Models\Sessao;
use App\Models\Registro;
use App\Models\Evolucao;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------------------------------
        // 1) CRIAR PROFISSIONAL FIXO
        // -----------------------------------------------------
        $user = User::factory()->create([
            'name' => 'Profissional Teste',
            'email' => 'profissional@teste.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // -----------------------------------------------------
        // 2) CRIAR PACIENTES
        // -----------------------------------------------------
        $pacientes = Paciente::factory()
            ->count(30) // <<< AJUSTE A QUANTIDADE
            ->create([
                'profissional_id' => $user->id,
            ]);

        // -----------------------------------------------------
        // 3) CRIAR CONSULTAS PARA CADA PACIENTE
        // -----------------------------------------------------
        foreach ($pacientes as $paciente) {

            $consultas = Consulta::factory()
                ->count(3) // <<< 3 consultas por paciente
                ->create([
                    'profissional_id' => $user->id,
                    'paciente_id' => $paciente->id,
                ]);

            // -----------------------------------------------------
            // 4) PRA CADA CONSULTA, CRIAR SESSÕES + EVOLUÇÕES
            // -----------------------------------------------------
            foreach ($consultas as $consulta) {

                // Criar 1 sessão para esta consulta
                $sessao = Sessao::factory()->create([
                    'profissional_id' => $user->id,
                    'paciente_id' => $paciente->id,
                    'consulta_id' => $consulta->id,
                ]);

                // Criar evoluções
                Evolucao::factory()
                    ->count(1)
                    ->create([
                        'profissional_id' => $user->id,
                        'paciente_id' => $paciente->id,
                        'consulta_id' => $consulta->id,
                    ]);

                // -----------------------------------------------------
                // 5) CRIAR REGISTROS PARA A SESSÃO
                // -----------------------------------------------------
                Registro::factory()
                    ->count(2)
                    ->create([
                        'profissional_id' => $user->id,
                        'paciente_id' => $paciente->id,
                        'sessao_id' => $sessao->id,
                    ]);
            }
        }

        echo "\n=== SEED FINALIZADO COM SUCESSO ===\n";
        echo "Profissional: profissional@teste.com / password\n\n";
    }
}
