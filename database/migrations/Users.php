<?php

namespace Database\Migrations;

use App\Models\User;
use zFramework\Core\Crypter;
use zFramework\Core\Facades\Str;

class Users
{
    static $charset = "utf8mb4_general_ci";
    static $table   = "users";
    static $db      = "local";

    public static function columns()
    {
        return [
            'id'        => ['primary'],
            'username'  => ['varchar:51', 'unique'],
            'password'  => ['varchar:50'],
            'email'     => ['varchar:50', 'unique'],
            'api_token' => ['varchar:60', 'required'],

            'timestamps',
            'softDelete',
        ];
    }

    public static function oncreateSeeder()
    {
        $user = new User;
        $user->insert([
            'username'  => 'admin',
            'password'  => Crypter::encode('admin'),
            'email'     => Str::rand(15) . '@localhost.com',
            'api_token' => Str::rand(60)
        ]);
    }
}
