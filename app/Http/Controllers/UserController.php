<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use App\Traits\UserDetailTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseTrait,UserDetailTrait;
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'pronouns' => 'present|in:She/Her,He/Him,They/Them' ,
            'default_email' => 'required|string|unique:users,email',
            'account_type' => 'required|string|exists:account_types,type',
            'password' => 'required|string|min:6|confirmed',
        ];

        if ($request->get('account_type') == 'Teacher'){
            $rules = array_merge($rules,[

            ]);
        }else if ($request->get('account_type') == 'Student'){
            $rules = array_merge($rules,[

            ]);
        }
        return response()->json([
            "result" => 200,
            "user_type" => $request->get('user_type')
        ]);
    }
}
