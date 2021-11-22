<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private const USER_DELEGATE = 'p';

    private const USER_SUPPORT = 'e';

    private const UNCONFIRMED_INVITATION = 'n';

    private const REJECTED_INVITACION = 'i';

    public function redirect(Request $request)
    {
        $user = Auth::user();

        if ($user->type === self::USER_DELEGATE) {
            return $this->redirectIfIsDelegateUser($user);
        }

        if($user->type === self::USER_SUPPORT)
        {
            return $this->redirectIfIsSupportUser();
        }

        return $this->redirectIfAdminUser($user);

    }

    private function redirectIfIsDelegateUser(User $user)
    {
        try {

            $invitacion = $user->policia->sillas[0]->pivot;

            if ($invitacion->confirmacion === self::UNCONFIRMED_INVITATION) {
                return redirect()->route('front.invitacion.confirm', ['codigoInvitacion' => $invitacion->codigo_invitacion]);
            }
            return redirect()->route('front.policia.index');


        } catch (\Exception $e) {
            return redirect()->route('front.policia.index');
        }

    }

    private function redirectIfIsSupportUser()
    {
        return redirect()->route('invitacion.escanear');
    }

    private function redirectIfAdminUser()
    {
        return redirect()->route('policia.index');
    }


}
