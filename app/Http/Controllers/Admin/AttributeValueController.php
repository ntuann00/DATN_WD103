<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class AttributeValueController extends BaseController
{

    public function index()
    {
        $attributeValues = AttributeValue::paginate(5);
        return view('admin.attributeValues.index', compact('attributeValues'));
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
