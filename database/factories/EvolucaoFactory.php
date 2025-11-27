<?php

namespace Database\Factories;

use App\Models\Evolucao;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvolucaoFactory extends Factory
{
    protected $model = Evolucao::class;

    public function definition(): array
    {
        return [
            'profissional_id' => 1,
            'paciente_id' => 1,
            'consulta_id' => 1,
            'tipo' => fake()->randomElement([
                'evolucao',
                'interconsulta',
                'anotacao',
                'feedback'
            ]),
            'conteudo' => fake()->paragraph(3, true),
            'data_registro' => fake()->dateTimeBetween('-10 days', 'now'),
        ];
    }
}
