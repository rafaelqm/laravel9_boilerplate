<?php

namespace App\Http\Controllers;

use App\Correios\CorreiosJunior;
use Correios;

class PostOfficeController extends Controller
{
    public function searchZipcode()
    {
        $correios = new CorreiosJunior();
        return $correios->buscaCep(request()->zipcode);
    }
}
