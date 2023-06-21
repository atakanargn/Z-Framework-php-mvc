<?php

namespace App\Controllers;

use App\Models\User;
use zFramework\Core\Abstracts\Controller;
use zFramework\Core\Facades\Cookie;

class HomeController extends Controller
{

    public function __construct($method)
    {
        // echo $method;
        $this->user = new User;
    }

    /** Index page | GET: /
     * @return mixed
     */
    public function index()
    {

        // var_dump(Cookie::set('selam', 'hey'));
        // var_dump(Cookie::get('selam'));
        // // var_dump(Cookie::delete('selam'));

        // exit;

        // or you can set model like `(new User)->get();`
        return view('welcome');
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
        abort(404);
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