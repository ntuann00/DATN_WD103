<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Users;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{

    public function index()
    {
       $users = Users::all();
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
       
    }
    public function store(Request $request)
    { 
    }
    public function show($id)
    {

    
    }

    public function edit($id)
    {
     
    }

    public function update(Request $request, $id)
    {
        
    }
    public function destroy($id) {
              
    }
}
