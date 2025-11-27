<?php

namespace Database\Factories;

use App\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsultaFactory extends Factory
{
    protected $model = Consulta::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-30 days', '+30 days');

        return [
            'profissional_id' => 1,
            'paciente_id' => 1, // sobrescrito no seeder
            'titulo' => fake()->randomElement(['Consulta Inicial', 'Retorno', 'Acompanhamento']),
            'data_hora_inicio' => $start,
            'data_hora_fim' => (clone $start)->modify('+50 minutes'),
            'observacoes' => fake()->sentence(1000),
            'status' => fake()->randomElement(['agendado', 'confirmado', 'atendido']),
        ];
    }
}
