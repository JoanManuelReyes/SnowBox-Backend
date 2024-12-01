<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PdfService;

class PdfServiceController extends Controller
{   

    private PdfService $pdfservice;

    public function __construct(PdfService $pdfservice)
    {
        $this->pdfservice = $pdfservice;
    }

    public function generarPDF(Request $request)
    {
        return $this->pdfservice->GenerarPDF($request);
    }
}