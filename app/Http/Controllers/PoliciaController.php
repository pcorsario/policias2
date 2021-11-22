<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePoliciaRequest;
use App\Models\File;
use App\Models\Policia;
use App\Services\Policias\FindPoliciaService;
use App\Services\Policias\UpdatePoliciaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PoliciaController extends Controller
{

    public function index()
    {
        return Inertia::render('Dashboard' , [
            'csrf' => csrf_token()
        ]);
    }

    public function get()
    {
        $user = Auth::user();
        $findPoliciaService = new FindPoliciaService();
        $data = $findPoliciaService->execute($user->policia->id);
        return response()->json($data);
    }

    public function update(UpdatePoliciaRequest $request, Policia $policia)
    {
        $updatePoliciaService = new UpdatePoliciaService();
        $updatePoliciaService->execute($policia, $request->validated());
        return redirect()->back();
    }

    public function testPhoto()
    {
        return Inertia::render('Policies/FormPhoto', [
            'csrf' => csrf_token()
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $user = Auth::user();
        $fileName = $user->identify . '.' . $request->file('file')->extension();
        $ubication = $request->file('file')->storeAs('fotos-delegados', $fileName, 'public');
        $user->profile_photo_path = $ubication;
        $user->save();
    }
}
