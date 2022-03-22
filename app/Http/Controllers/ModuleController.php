<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    use ResponseTrait, ValidatorTrait;

    protected $module = "Modül";

    public function create(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'name' => 'required|string',
            'description' => 'required|string'
        ];
        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }
            $result = DB::table('modules')->insert([
                'title' => $request->get('title'),
                'name' => $request->get('name'),
                'description' => $request->get('description')
            ]);

        return $this->responseTrait([
            'code' => null,
            'message' => $this->module,
            'result' => $result
        ], 'create');
    }
    public function read(){
        $result = DB::table('modules')->get();

        return $this->responseTrait([
            'code' => null,
            'message' => $this->module,
            'result' => $result
        ], 'read');
    }

    public function delete($id){
        $result = DB::table('modules')->delete($id);

        return $this->responseTrait([
            'code' => null,
            'message' => $this->module,
            'result' => $result
        ], 'delete');
    }
}
