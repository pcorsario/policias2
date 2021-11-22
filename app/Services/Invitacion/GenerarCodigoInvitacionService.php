<?php


namespace App\Services\Invitacion;

use Illuminate\Support\Str;

class GenerarCodigoInvitacionService
{
    public function execute()
    {
        return Str::uuid();
    }
}
