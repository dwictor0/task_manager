<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sugestao extends Model
{
  protected $table = 'sugestao';

  protected $fillable =  [
    'titulo',
    'descricao',
    'total_votos',
    'usuario_id',
  ];
}
