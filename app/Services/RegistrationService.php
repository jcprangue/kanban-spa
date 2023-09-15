<?php

namespace App\Services;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class RegistrationService
{
    /**
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function store($request)
    {
        $user = User::create([
            'name' => $request->first_name . " " . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $user;
    }
}
