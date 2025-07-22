<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SugestaoVotos extends Model
{
    protected $table = "sugestao_votos";

    protected $fillable = [
        'votos_id',
        'usuario_id',
        'sugestao_id'
    ];
public function sugestao()
{
    return $this->belongsTo(Sugestao::class, 'sugestao_id','id');
}
}
