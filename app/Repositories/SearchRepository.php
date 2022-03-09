<?php

namespace App\Repositories;

use App\Correios\CorreiosInterface;

class SearchRepository
{

    public function buscaCep(CorreiosInterface $correios, $cep)
    {
        return $correios->buscaCep($cep);
    }
}
