<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cuadrante;
use App\Models\Mesa;
use App\Models\Silla;
use App\Services\AsignacionSillas\AsignacionSillaPorMesaService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CuadranteController extends Controller
{
    public function index(){
        return Inertia::render('Cuadrantes/Index', [
                'cuadrantes' => Cuadrante::with('mesas.sillas')->get()
            ]
        );
    }

    public function distribucionMesasYSillas(){
        return Cuadrante::with('mesas.sillas')->get();
    }

    public function asignacionSillasAMesas()
    {
        $asignacionSillaPorMesaService = new AsignacionSillaPorMesaService();
        $data = $asignacionSillaPorMesaService->execute();
        return $data;
    }

    public function update(Request $request, Cuadrante $cuadrante)
    {
        $validated = $request->validate([
            'descripcion' => 'required|max:30'
        ]);

        $cuadrante->descripcion = $validated['descripcion'];
        $cuadrante->save();
        return redirect()->back();
    }

    public function createAll(){
        $counterTable = 1;

        for($i = 1; $i <=4; $i++)
        {
            $cuadrante = Cuadrante::create([
                'descripcion' => 'Cuadrante ' . $i,
                'numero' => $i
            ]);

            for($j = 1; $j <= 15; $j++)
            {
                $mesa = Mesa::create([
                    'descripcion' => 'Mesa ' . $counterTable,
                    'numero' => $counterTable,
                    'cuadrante_id' => $cuadrante->id,
                    'posicion' => $j
                ]);

                foreach (['B', 'C', 'A', 'D', 'F', 'E'] as $index => $letraSilla)
                {
                    Silla::create([
                        'descripcion' => $mesa->numero . $letraSilla,
                        'posicion' => $index + 1,
                        'mesa_id' => $mesa->id
                    ]);
                }
                $counterTable++;

            }

        }

    }
}
