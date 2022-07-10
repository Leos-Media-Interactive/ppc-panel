<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $role = auth()->user()->role;

        if($role === 'manager' || $role === 'super_admin'){
            return redirect()->route('page.clients');
        }else{
            return redirect()->route('stats.account');
        }

    }
}
