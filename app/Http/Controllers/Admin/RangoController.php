<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveRangoRequest;
use App\Http\Requests\UpdateRangoRequest;
use App\Models\Rango;
use App\Services\Rangos\ListaTodosRangoService;
use App\Services\Rangos\SaveRangoService;
use App\Services\Rangos\UpdateRangoService;
use Inertia\Inertia;

class RangoController extends Controller
{
    private $listAllRangesService;

    public function __construct(ListaTodosRangoService $listAllRangesService)
    {
        $this->listAllRangesService = $listAllRangesService;
    }

    public function index()
    {
        return Inertia::render('Ranges/Index');
    }

    public function getAllRangos()
    {
        return $this->listAllRangesService->execute();
    }

    public function save(SaveRangoRequest $request)
    {
        $saveRangoService = new SaveRangoService();
        $data = $saveRangoService->execute($request->validated());
        $request->session()->flash('data', $data);
        return back();
    }

    public function update(UpdateRangoRequest $request, Rango $rango)
    {
        $updateRangoService = new UpdateRangoService();
        $updateRangoService->execute($rango, $request->validated());
        return redirect()->back();
//        return response()->json([
//            'updated' => true
//        ]);

    }
}
