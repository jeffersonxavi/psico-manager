<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evolucao extends Model
{
    protected $table = 'evolucoes'; // força o nome correto da tabela

    protected $fillable = [
        'paciente_id',
        'consulta_id',
        'profissional_id',
        'tipo',
        'conteudo',
        'data_registro'
    ];

    public static $tipos = [
        'evolucao',
        'interconsulta',
        'anotacao',
        'feedback'
    ];

    public function paciente() { return $this->belongsTo(Paciente::class); }
    public function consulta() { return $this->belongsTo(Consulta::class); }
    public function profissional() { return $this->belongsTo(User::class, 'profissional_id'); }
}
