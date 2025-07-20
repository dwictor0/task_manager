<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deputados extends Model
{
  protected $table = 'deputados';

  protected $fillable = [
    'nome',
    'partido',
    'uf',
    'imagem_deputado',
  ];

  public function tarefas()
  {
    return $this->hasMany(ListaTarefas::class, 'deputado_id');
  }

}
