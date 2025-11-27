<?php

namespace Database\Factories;

use App\Models\Sessao;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessaoFactory extends Factory
{
    protected $model = Sessao::class;

    public function definition(): array
    {
        return [
            'profissional_id' => 1,
            'paciente_id' => 1,
            'consulta_id' => 1,
            'conteudo' => fake()->paragraph(4, true),
            'data_sessao' => fake()->dateTimeBetween('-20 days', 'now'),
        ];
    }
}
