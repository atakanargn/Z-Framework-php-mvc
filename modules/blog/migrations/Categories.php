<?php

namespace Modules\Blog\Migrations;

#[\AllowDynamicProperties]
class Categories
{
    static $storageEngine = "InnoDB";
    static $charset       = "utf8mb4_general_ci";
    static $table         = "categories";
    static $db            = "local";
    static $prefix        = "";

    public static function columns()
    {
        return [
            'id'          => ['primary'],
            'parent_id'   => ['int'],
            'title'       => ['varchar:50'],
            'slug'        => ['varchar:150'],
            'description' => ['text'],
            'timestamps'
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
