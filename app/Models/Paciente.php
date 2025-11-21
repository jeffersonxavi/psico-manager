<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'profissional_id', 'nome', 'data_nascimento', 'telefone', 'email', 
        'contato_emergencia', 'estado_civil', 'profissao', 'endereco', 'observacoes'
    ];

    public function profissional()
    {
        return $this->belongsTo(User::class, 'profissional_id');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
