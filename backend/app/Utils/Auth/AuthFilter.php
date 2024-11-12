<?php

namespace App\Utils\Auth;
use Illuminate\Support\Facades\Auth;

class AuthFilter
{
    public function UserData()
    {
        return Auth::user();
    }

    public function Check(){
        return Auth::check();
    }

}
