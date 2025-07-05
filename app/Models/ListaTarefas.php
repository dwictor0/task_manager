<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaTarefas extends Model
{
  use SoftDeletes;
  protected $table = 'lista_tarefas';

  protected $fillable = [
    'titulo',
    'descricao',
    'status',
    'user_id',
    'prioridade',
    'data_de_vencimento'
  ];
  
  protected $casts = [
     'data_de_vencimento' => 'datetime:Y-m-d H:i:s',
  ];
}
