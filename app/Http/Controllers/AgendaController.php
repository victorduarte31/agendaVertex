<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Http\Requests\CreateFormRequest;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    private $agenda;
    private $totalPaginas = 5;

    public function __construct(Agenda $agenda)
    {
        $this->agenda = $agenda;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contatos = $this->agenda->getResultados($request->find);

        return response()->json($contatos, 200);
        /*$contatos = $this->agenda->getResultados($request->all(), $this->totalPaginas);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFormRequest $request)
    {
        $contato = $this->agenda->create($request->all());

        return response()->json($contato, 201);
    }

}
