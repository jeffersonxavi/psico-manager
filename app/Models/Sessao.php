<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sessao extends Model
{    
    use HasFactory;

    protected $table = 'sessoes'; // importante, pois Laravel pluraliza errado
    protected $fillable = ['paciente_id','profissional_id','conteudo','data_sessao','consulta_id'];
    protected $casts = [
        'data_sessao' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function profissional()
    {
        return $this->belongsTo(User::class,'profissional_id');
    }

    public function registros()
    {
        return $this->hasMany(Registro::class,'sessao_id');
    }
        public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
}
