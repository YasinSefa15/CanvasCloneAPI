<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccountTypeController extends Controller
{
    use ResponseTrait;
    public function create(Request $request){
        $validator = Validator::make($request->all(),['type' => 'required|string|max:32|unique:account_types']);
        if($validator->fails()){
            return $this->responseTrait([
                'code' => 400,
                'message' => "Lütfen formunuzu kontrol ediniz.",
                'error' => $validator->errors()
            ]);
        }

        $result = DB::table('account_types')->insert([
           'type' => Str::ucfirst(Str::lower($request->get('type')))
        ]);

        return $this->responseTrait([
            'code' => null,
            'message' => "Kullanıcı tipi oluşturma işlemi",
            'result' => $result
        ], 'create');
    }

    public function read(Request $request){
        $result = DB::table('account_types')->get();

        return $this->responseTrait([
            'code' => null,
            'message' => "Kullanıcı tipi görüntüleme işlemi",
            'result' => $result
        ], 'read');
    }
}
