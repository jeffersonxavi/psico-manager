<?php

namespace App\Policies;

use App\Models\Paciente;
use App\Models\User;

class PacientePolicy
{
    public function view(User $user, Paciente $paciente)
    {
        return $user->id === $paciente->profissional_id;
    }

    public function create(User $user)
    {
        return true; // qualquer profissional logado pode criar
    }

    public function update(User $user, Paciente $paciente)
    {
        return $user->id === $paciente->profissional_id;
    }

    public function delete(User $user, Paciente $paciente)
    {
        return $user->id === $paciente->profissional_id;
    }
}