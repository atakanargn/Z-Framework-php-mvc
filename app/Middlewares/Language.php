<?php

namespace App\Middlewares;

use zFramework\Core\Facedas\Lang;

class Language
{
    public function __construct()
    {
        Lang::locale($_SESSION['lang'] ?? null);
        return true;
    }
}
