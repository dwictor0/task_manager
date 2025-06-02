<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaTarefas extends Model
{
    protected $table = 'lista_tarefas';

    protected $fillable = [
        'titulo','descricao','status','created_at'
    ];
}
