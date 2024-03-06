<?php
namespace Modules\Blog\Migrations;

#[\AllowDynamicProperties]
class Blog
{
    static $storageEngine = "InnoDB";
    static $charset       = "utf8mb4_general_ci";
    static $table         = "Blog";
    static $db            = "local";
    static $prefix        = "";

    public static function columns()
    {
        return [
            'id' => ['primary']
        ];
    }
    
    # e.g. a self seeder 
    # public static function oncreateSeeder()
    # {
    #     $user = new User;
    #     $user->insert([
    #         'username'  => 'admin',
    #         'password'  => Crypter::encode('admin'),
    #         'email'     => Str::rand(15) . '@localhost.com',
    #         'api_token' => Str::rand(60)
    #     ]);
    # }
}