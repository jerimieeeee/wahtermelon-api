<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Http\Controllers\Controller;
use App\Services\PhilHealth\SoapService;
use Illuminate\Http\Request;

class KonsultaController extends Controller
{
    public function index(SoapService $service)
    {
        return $service->soapCall();
    }
}
