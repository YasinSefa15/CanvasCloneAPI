<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ValidatorTrait
{
    use ResponseTrait;
    public function validator($request,$rules){
        $validation = Validator::make($request,$rules);
        if($validation->fails()){
            return $this->responseTrait([
                'code' => 400,
                'message' => 'Lütfen formunuzu kontrol ediniz.',
                'result' => $validation->errors()
            ]);
        }
        return null;
    }
}
