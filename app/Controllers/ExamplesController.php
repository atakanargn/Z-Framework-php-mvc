<?php

namespace App\Controllers;

use App\Models\User;
use zFramework\Core\Crypter;
use zFramework\Core\Facades\DB;
use zFramework\Core\Facades\Str;
use zFramework\Core\Validator;

class ExamplesController
{

    public function __construct()
    {
        $this->user = new User;
        $this->db = new DB;
    }

    /** Index page | GET: /
     * @return mixed
     */
    public function index($createdUser = [])
    {
        $this->delete_user = new User;
        $this->delete_user->where('id', '=', 1)->delete();

        // echo "<pre>User List with Deleteds: ";
        // print_r($this->db->table('users')->get());
        // echo "</pre>";

        return view('examples', [
            'users' => $this->user->select('*, COUNT(username) as usernameCount')->groupBy('username')->paginate(20),
            'users2' => $this->user->paginate(10, 'page_2'),
            'createdUser' => $createdUser
        ]);
    }

    /** Show page | GET: /id
     * @param integer $id
     * @return mixed
     */
    public function show($id)
    {
        abort(404);
    }

    /** Create page | GET: /create
     * @return mixed
     */
    public function create()
    {
        abort(404);
    }

    /** Edit page | GET: /id/edit
     * @param integer $id
     * @return mixed
     */
    public function edit($id)
    {
        abort(404);
    }

    /** POST page | POST: /
     * @return mixed
     */
    public function store()
    {
        $validate = Validator::validate($_POST, [
            'username' => ['required'],
            'password' => ['required', 'same:re-password'],
            're-password' => ['required'],
            'email' => ['required', 'email', 'unique:users cl=email,db=local']
        ]);
        unset($validate['re-password']);

        $validate['password'] = Crypter::encode(request('password'));
        $validate['api_token'] = Str::rand(30, true);

        $createdUser = $this->user->insert($validate);

        return $this->index($createdUser);
    }

    /** Update page | PATCH/PUT: /id
     * @return mixed
     */
    public function update($id)
    {
        abort(404);
    }

    /** Delete page | DELETE: /id
     * @return mixed
     */
    public function delete($id)
    {
        abort(404);
    }
}
