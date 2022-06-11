### 0.1. Z Framework (V1.0.1)
### 0.2. Easiest, fastest PHP framework. (Simple)

### 0.3. Document
- [1. Route](#1-route)
  - [1.1. Form examples](#11-form-examples)
  - [1.2. Route Options](#12-route-options)
  - [1.3. Find Route's Url](#13-find-routes-url)
- [2. Model](#2-model)
  - [2.1. Database Migrate](#21-database-migrate)
- [3. Controller](#3-controller)
- [4. View](#4-view)
- [5. zhelper](#5-zhelper)
- [6. Csrf](#6-csrf)
- [7. Language](#7-language)
- [8. Alerts](#8-alerts)
- [9. Validator](#9-validator)
- [10. Middleware](#10-middleware)
- [11. API](#11-api)
- [12. Development](#12-development)
- [13. Helper Methods](#13-helper-methods)
- [14. Run Project](#14-run-project)

## 1. Route
```php
    // Any METHOD Route
   Route::any('/', function() {
        return 'Method: ' . method();
   });
    
    // Get METHOD Route
   Route::get('/', function() {
        return 'Hi 👋';
   });
   
    // POST METHOD Route
   Route::post('/', function() {
        return 'You verified CSRF Token.';
   });
   
   // PATCH METHOD Route
   Route::patch('/', function() {
        return 'patch.';
   });
   
    // PUT METHOD Route
   Route::put('/', function() {
        return 'put.';
   });
   
   // DELETE METHOD Route
   Route::delete('/', function() {
        return 'delete.';
   });
   
   // if you create resource controller it's like that simple
   Route::resource('/', TestController::class);
   
   
    Resource Route list:
   
    |--------------------------------------------|
    | URL        | METHOD    | Callback Function |
    |------------|-----------|-------------------|
    | /          | GET       | index()           |
    | /          | POST      | store()           |
    | /{id}      | GET       | show($id)         |
    | /{id}/edit | GET       | edit($id)         |
    | /create    | GET       | create()          |
    | /{id}      | PUT/PATCH | update($id)       |
    | /{id}      | DELETE    | delete($id)       |
    |--------------------------------------------|
```
### 1.1. Form examples

```html
    You must use csrf token for POST methods. (if you not add "no-csrf" option.)


    <!-- for store() method -->
    <form method="POST">
        <?= Csrf::csrf() ?>
        <input type="submit">
    </form>

    <!-- for update() method -->
    <form action="/1" method="POST">
        <?= Csrf::csrf() ?>
        <?= inputMethod('PATCH') ?>
        <input type="submit">
    </form>

    <!-- for delete() method -->
    <form action="/1" method="POST">
        <?= Csrf::csrf() ?>
        <?= inputMethod('DELETE') ?>
        <input type="submit">
    </form>

    Also you can use `csrf()` method
    <form method="POST">
        <?= csrf() ?>
        ...
    </form>
```


Callback function can be a Controller class example:
```php
    // App\Controllers\TestController.php
    class ...{
        public function index() {
            return 'Hi 👋';
        }
    }
    // Route/web.php
    Route::get('/', [TestController::class, 'index']);
```
How i use parameters? (it's same for Controller's functions)
```php
    Route::get('/{id}', function($id) {
        return "ID: $id";
    })
```
ALSO you can normal query like /1?test=true

### 1.2. Route Options
```php                                                  
                                                        // Last array is Options
    Route::post('/store', [TestController::class, 'store'], [
        'name' => 'store',
        'no-csrf' => true,
        'middlewares' => [Auth::class]
    ]);

    // Other way for middleware (if you use that way you can not find route name.)
    Middleware::middleware([Auth::class, Guest::class], function ($declined) {
        if (count($declined)) return;
        
        Route::get('/test', function () {
            return "Hey 👋";
        }, [
            'name' => 'test' // if middleware not verify you can not find that name.
        ]);
    });

```
### 1.3. Find Route's Url
```php
    // Route/web.php
    Route::get('/test/{id}/{username}', function ($id, $username) {
        echo "$id - $username";
    }, [
        'name' => 'test'
    ]);

    // Usage:
    echo Route::name('test', ['id' => 1, 'username' => 'Admin']); // output: /test/1/Admin
```

## 2. Model
```php
    class User extends Model {
        public $table = "users";
        public $db = "local"; // (optional) if you do not write that it's connect your first connection.
    }
    
    // Usage:
    
    use App\Models\User;
    $user = new User;
    echo "<pre>";
    print_r([
        "get" => $user->get(),
        "first" => $user->where('id', '=', 1)->first(),
        "count" => $user->count(),
        "insert" => $user->insert([
            'username' => 'username',
            'password' => 'password',
            'email' => 'email@mail.com'
        ]),
        "update" => $user->where('id', '=', 1)->update([
            'email' => 'test@mail.com'
        ]),
        "delete" => $user->where('id', '>', 0)->delete()
    ]);

    // if you wanna get type class = ->get(true) | ->first(true);

    // Where example
    $user->where('id', '=', 1)->where('email', '=', 'test@mail.com', 'OR')->get();

    // Select example
    $user->select('id, username')->get();

    // OrderBy example
    $user->orderBy(['id' => 'ASC', 'username' => 'DESC'])->get();
    
    // Limit example args: 10(startCount), 10(rowCount)
    $user->limit(5, 10)->get();

    // Joins example
    $user->join('LEFT|RIGHT|OUTER|FULL|NULL', 'table_name', ['table_name.id', '=', 'this_table.id'])->get();

```
### 2.1. Database Migrate
```php
    // Folder path: database/migrations

    // Example: (that file is real)
    // (Folder path)/Users.php
    class Users
    {
        static $table = "users"; // create table name
        static $db = 'local'; // db key from database/connections.php

        public static function columns() // Insert columns
        {
            return [
                'id' => ['primary'],
                'username' => ['varchar:50', 'charset:utf8:general_ci'],
                'password' => ['varchar:50', 'charset:utf8:general_ci'],
                'email' => ['varchar:50', 'charset:utf8:general_ci', 'unique'],
                'api_token' => ['varchar:60', 'required', 'charset:utf8:general_ci']
            ];
        }
    }

    // can use parameters:
    [
        'primary',
        'unique', 
        'text',
        'int', 
        'varchar', 
        'varchar:(length)', 
        'required', 
        'nullable', 
        'default', 
        'default:default value', 
        'charset:utf8mb4:general_ci'
    ]

```

## 3. Controller
```php
    class ... {
        public function __construct() {
            echo "Hi, this is __construct.";
            $this->user = new User;
        }
        
        public function index() {
            $hi = 'hey';                                    // resource/views/main.php template
            return View::view('home.index', compact('hi'), 'main');
        }
        
        public function show($id) {
            return View::view('home.user', ['user' => $this->user->first()], 'main');
        }
    }
```
## 4. View
```php
    use Core\View;                     // resource/views/main.php template
    echo View::view('home.index', ['hi' => 'hey'], 'main');
    
    // in home.index:
    <div>
        List:
        <?= View::view('home.list', $view_parameters); ?> // Output: echo $hi; = hey
    </div>
```
## 5. zhelper
```php
    ....
    C:\Users\...\Desktop\Project>php zhelper
    
    // Makes Usage:
    # Controller                // what are u want  // if u want get ready resource controller (Optional)
    > php zhelper make controller Test\TestController resource
    
    # Model                  // what are u want
    > php zhelper make model Test\Test
    
    # Middleware                  // what are u want
    > php zhelper make middleware Test\Test

    # Database Migration          // what are u want
    > php zhelper make migration Users


    # Database Migrator:
    php zhelper db migrate // output: just add/modify after changes columns.
    php zhelper db migrate fresh // output: reset table and write all columns.

    // Note: if you create first time tables you must do use fresh option.
```
## 6. Csrf
```php
    // Usage:
    Csrf::get(); // Output: random_csrf_string
    Csrf::set(); // Random/Renew set token
    Csrf::unset(); // Destroy csrf token
    Csrf::remainTimeOut(); // How much seconds left for change csrf token
```
## 7. Language
```php
    // Usage:
    
    // Dir tree:
    tr -> 
        lang.php // return array
        auth.php // return array
    en -> 
        lang.php // return array
        auth.php // return array

    // if you want change locale
    Lang::locale('tr');
    
    // if you wanna get a parameter
    Lang::get('lang.test');
    Lang::get('auth.wrong-password');

    // How i select default lang? (if not exists in lang list browser language select default)
    config -> 
            app.php ->
                    lang => 'tr'

    // get lang list
    print_r(Lang::list());
```

## 8. Alerts
```php
    // Alerts is show just one time, when you refresh your page Alerts is gone.

    # Usage:
    Alerts::danger('text');
    Alerts::success('text');
    Alerts::info('text');
    Alerts::warning('text');
    
    // if you wanna use like chain
    Alerts::danger('text')::success('text')::info('text')::warning('text');

    // get alerts
    Alerts::get(); // output: Array ([0] => ('success', 'text'), [1] => ('danger', 'text'))

    // unset alerts
    Alerts::unset();

```

## 9. Validator
```php
    // In array validate values.
    // Current: type, required, max, min, same.
    
    Validator::validate($_REQUEST, [
        'test1' => ['type:string', 'required', 'max:10', 'min:5', 'same:test2'],
        'test2' => ['same:test1'],
    ]);
```
##  10. Middleware
```php
    # App\Middlewares\Auth.php
    # Validate first and go on.
    
    namespace App\Middlewares;
    class Auth
    {
        public function __construct()
        {
            if (@$_SESSION['user_id']) return true;
        }
    
        public function error()
        {
            abort(401);
        }
    }

    // Usage:
    Middleware::middleware([Auth::class, Guest::class]); // output: false
    Middleware::middleware([Auth::class]); // if you are logged in      # output: true 
    Middleware::middleware([Guest::class]); // if you are not logged in # output: true 
    

    Middleware::middleware([Auth::class, Guest::class], function($declined) {
        print_r($declined);
    }); // if you are logged in     # output: Array ('Guest::class')
        // if you are not logged in # output: Array ('Auth::class')
```

## 11. API
```php
    # route/api.php
    Route::get('/test', function () {
        echo "API Page / user_id: " . Auth::id();
    });
    // example: http://localhost/api/test?user_token=12345678 (user logged in.)
```

## 12. Development
```php
    // Database connections
    # Folder: database/connections.php
    <?php
    
    // before
    $databases = [
        'local' => ['mysql:host=localhost;dbname=test;charset=utf8mb4', 'root', '123123'],
    ];

    # add a database
    $databases = [
        'local' => ['mysql:host=localhost;dbname=test;charset=utf8mb4', 'root', '123123'],
        'custom_db_name' => ['mysql:host=localhost;dbname=test_2;charset=utf8mb4', 'root', '123123'],
    ];

    // result database two connection.
```

## 13. Helper Methods
```php
    // main base path
    base_path("optional url add");
    
    // Public path
    public_path("optional url add");

    // Show host name
    host();

    // Redirect
    redirect("URL");

    // Redirect to REFERER
    back();

    // Show current uri
    uri();

    // get current request method
    method();

    // show input method
    inputMethod('GET|POST|PATCH|PUT|DELETE');

    // Get Client IP
    ip();

    // Set http response code 200 to 500 and optional message.
    abort(200, 'OK');

    // get request
    request('name');

    // Response for Controllers or routes callbacks
    response('json', array);

    // show csrf input
    csrf();
```

## 14. Run Project
```php
    ....
    C:\Users\...\Desktop\Project>php run (press enter)
```