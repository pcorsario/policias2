<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Exports\PoliciasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SavePoliciaRequest;
use App\Http\Requests\Admin\UpdatePoliciaRequest;
use App\Models\Policia;
use App\Models\Rango;
use App\Services\Policias\ListaTodosPoliciaService;
use App\Services\Policias\SavePoliciaService;
use App\Services\Policias\UpdatePoliciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class PoliciaController extends Controller
{
    public function __construct()
    {
    }

    public function index(){
        return Inertia::render('Policies/Index');
    }

    public function all()
    {
        $getAllPolicies = new ListaTodosPoliciaService();
        return $getAllPolicies->exectue();
    }

    public function policiaPorRango(Rango $rango)
    {
        return $rango->policias;
    }

    public function save(SavePoliciaRequest $request)
    {
        try {
            $formInput = $request->validated();
            $userAction = new CreateNewUser();
            $dataUserCreated = $userAction->create([
                'name' => $formInput['apellido_paterno'] . ' ' . $formInput['apellido_materno'] . ' ' . $formInput['nombres'],
                'identify' => $formInput['cedula'],
                'type' => 'p',
                'email' => $formInput['correo'],
                'password' => $formInput['cedula'],
                'password_confirmation' => $formInput['cedula']
            ]);
            $savePoliciaService = new SavePoliciaService();
            $formInput['user_id'] = $dataUserCreated->id;
            $formInput['codigo_confirmacion'] = Str::uuid();
            $data = $savePoliciaService->execute($formInput);
            $request->session()->flash('data', $data);
            return redirect()->back();

        }catch (Exception $e){
            throw new Exception($e);
        }

    }

    public function update(UpdatePoliciaRequest $request, Policia $policia)
    {
        $updatePoliciaService = new UpdatePoliciaService();
        $updatePoliciaService->execute($policia, $request->validated());
        return redirect()->back();
    }

    public function restablecerClave(Policia $policia)
    {
        $policia->user->password = Hash::make($policia->user->identify);
        $policia->user->save();
        return redirect()->back();
    }

    public function exportar()
    {
        return Excel::download(new PoliciasExport(), 'delegados.xlsx');
    }

    public function exportarPDF()
    {
        $delegados = Policia::with('rango')->get();
        $pdf = \PDF::loadView('pdf.datos-delegados', compact('delegados'));
        return $pdf->download('listado-delegados.pdf');
    }
    public function exportarIndividualPDF(Request $request, Policia $policia)
    {
        $delegados [] = $policia->load('rango');
        $pdf = \PDF::loadView('pdf.datos-delegados', compact('delegados'));
        return $pdf->download('listado-delegados.pdf');
    }
}
