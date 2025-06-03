<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaTarefas extends Model
{
    use SoftDeletes;
    protected $table = 'lista_tarefas';

    protected $fillable = [
        'titulo','descricao','status','created_at','user_id'
    ];
}
