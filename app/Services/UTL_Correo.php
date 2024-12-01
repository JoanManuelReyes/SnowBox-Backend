<?php

namespace App\Services;

use Resend\Laravel\Facades\Resend;

class UTL_Correo {

    public function enviarCorreo()
    {   
        return Resend::emails();
    }
}