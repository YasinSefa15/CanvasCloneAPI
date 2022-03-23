<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AccountTypeController extends Controller
{
    use ResponseTrait, ValidatorTrait;
    protected $module = "Kullanıcı tipi";

    public function create(Request $request){
        $validation = $this->validator($request->all(),['type' => 'required|string|max:32|unique:account_types']);
        if (isset($validation)){
            return $validation;
        }
        $result = DB::table('account_types')->insert([
           'type' => Str::ucfirst(Str::lower($request->get('type')))
        ]);

        return $this->responseTrait([
            'code' => null,
            'message' => $this->module,
            'result' => $result
        ], 'create');
    }

    public function read(){
        $result = DB::table('account_types')->get();

        return $this->responseTrait([
            'code' => null,
            'message' => $this->module,
            'result' => $result
        ], 'read');
    }

    public function delete(Request $request, $id){
        /** TODO : where?*/
        $result = DB::table('account_types')
            ->where('id','=',$id)
            ->delete($id);
        return $this->responseTrait([
            'code' => null,
            'message' => $this->module,
            'result' => $result
        ], 'delete');
    }
}
