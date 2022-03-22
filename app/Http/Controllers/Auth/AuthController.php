<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use App\Traits\TokenTrait;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ResponseTrait, ValidatorTrait, TokenTrait;
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'pronouns' => 'present|in:,She/Her,He/Him,They/Them' ,
            'email' => 'required|string|unique:users,email',
            'account_type' => 'required|string|in:Teacher,Student',
            'password' => 'required|string|min:6|confirmed'
        ];

        if ($request->get('account_type') == 'Teacher'){
            $rules = array_merge($rules,[
                'phone' => 'required|numeric|digits:10',
                'country' => 'required|string|max:255',
                'organization_type' => 'required|string|in:Further Education,Corporate Education,Government',
                'job_title' => 'required|string|max:255',
                'school_organization' => 'required|string|max:255',
            ]);
        }else{
            $rules = array_merge($rules,[
                'title' => 'nullable|string|max:255',
                'biography' => 'nullable|string|max:255',
            ]);
        }
        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        $model = User::create([
           'name' => $request->get('name'),
           'pronouns' => $request->get('pronouns'),
           'email' => $request->get('email'),
           'account_type' => $request->get('account_type'),
           'password' => $request->get('password'),
        ]);
        $model_detail = (isset($model) && $request->get('account_type') == 'Student') ?
            $model->studentDetails()->create([
                'title' => $request->get('title'),
                'biography' => $request->get('biography')
            ]) :
            $model->teacherDetails()->create([
                'phone' => $request->get('phone'),
                'country' => $request->get('country'),
                'job_title' => $request->get('job_title'),
                'organization_type' => $request->get('organization_type'),
                'school_organization' => $request->get('school_organization')
            ]);

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => array_merge($model->toArray(),$model_detail->toArray())
        ], 'create');
    }

    public function read(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' =>'required|string|min:6'
        ];
        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        $result = User::where('email',$request->get('email'))->first();
        $available = $result !=null && Hash::check($request->get('password'),$result->password);
        if($available){
            $token =  $this->token([
                'device' => $request->header('x-device'),
                'user_id' => $result->id
            ]);
        }
        return ($available) ?
            $this->responseTrait([
                'code' => null,
                'message' => "Giriş işlemi",
                'result' => $result,
                'token' => $token
            ], 'read') :
            $this->responseTrait([
                'code' => null,
                'message' => "Giriş işlemi"
            ], 'read');
    }
}
