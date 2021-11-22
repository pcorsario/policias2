<?php


namespace App\Services\Users;


use App\Models\User;

class GetAllUsersAdministratives
{
    public function execute()
    {
        return User::where('type', '<>', 'p')
            ->get();
    }
}
