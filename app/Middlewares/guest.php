<?php

namespace App\Middlewares;

use zFramework\Core\Facedas\Auth;

class Guest
{
    public function __construct()
    {
        if (!Auth::check()) return true;
        return false;
    }

    public function error()
    {
        abort();
    }
}
