<?php

namespace Database\Factories;

use App\Models\Registro;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroFactory extends Factory
{
    protected $model = Registro::class;

    public function definition(): array
    {
        return [
            'profissional_id' => 1,
            'paciente_id' => 1,
            'sessao_id' => 1,
            'tipo' => fake()->randomElement(Registro::$tipos),
            'conteudo' => fake()->paragraph(3, true),
            'data_registro' => fake()->dateTimeBetween('-10 days', 'now'),
        ];
    }
}
