<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\Users\GetAllUsersAdministratives;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Index');
    }

    public function all()
    {
        $users = (new GetAllUsersAdministratives())->execute();
        return $users;
    }

    public function save(Request $request)
    {
        $createNewUser = new CreateNewUser();
        $userCreated = $createNewUser->create($request->all());
        $request->session()->flash('data', $userCreated);
        return redirect()->back();
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if($request->filled('password'))
        {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->back();

    }
}
