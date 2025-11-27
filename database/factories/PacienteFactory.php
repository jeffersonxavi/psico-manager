<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            'profissional_id' => 1, // será sobrescrito no seeder
            'nome' => fake()->name(),
            'data_nascimento' => fake()->date(),
            'telefone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'contato_emergencia' => fake()->phoneNumber(),
            'estado_civil' => fake()->randomElement(['Solteiro', 'Casado', 'Divorciado', 'Viúvo']),
            'profissao' => fake()->jobTitle(),
            'endereco' => fake()->address(),
            'observacoes' => fake()->sentence(12),
        ];
    }
}
