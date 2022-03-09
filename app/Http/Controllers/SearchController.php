<?php

namespace App\Http\Controllers;

use App\Correios\CorreiosInterface;
use App\Correios\CorreiosJunior;
use App\Repositories\SearchRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function buscaPorCep($cep)
    {
        $searchRepo = new SearchRepository();
        $correios = new CorreiosJunior();
        return $searchRepo->buscaCep($correios, $cep);
    }
}
