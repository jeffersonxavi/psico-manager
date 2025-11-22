<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'profissional_id',
        'paciente_id',
        'titulo',
        'data_hora_inicio',
        'data_hora_fim',
        'observacoes',
        'status'
    ];

    protected $casts = [
    'data_hora_inicio' => 'datetime',
    'data_hora_fim' => 'datetime',
];
    public function profissional()
    {
        return $this->belongsTo(User::class, 'profissional_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
