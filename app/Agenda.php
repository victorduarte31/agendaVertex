<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agenda extends Model
{
    protected $fillable = [
        'nome', 'email', 'telefone', 'cep'
    ];

    public function getResultados($busca)
    {

        $query = DB::select("select * from agendas where nome like '%{$busca}%' or email like '%{$busca}%'");

        return $query;


    }

}
