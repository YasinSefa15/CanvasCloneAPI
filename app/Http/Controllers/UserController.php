<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResponseTrait;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ResponseTrait, ValidatorTrait;
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'pronouns' => 'required|in:None,She/Her,He/Him,They/Them' ,
            'email' => 'required|email|unique:users,email',
            'account_type' => 'required|string|exists:account_types,type',
            'password' => 'required|string|min:6|confirmed',
        ];

        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        $model = User::create([
            'name' => $request->get('name'),
            'pronouns' => $request->get('pronouns'),
            'email' => $request->get('email'),
            'account_type' => $request->get('account_type'),
            'password' => $request->get('password')
        ]);

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $model
        ], 'create');
    }

    public function read(Request $request){
        $models = User::all();
        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $models
        ], 'read');
    }

    public function update(Request $request,$id){
        $rules = [
            'name' => 'nullable|string',
            'pronouns' => 'nullable|in:,She/Her,He/Him,They/Them' ,
            'email' => 'nullable|string|unique:users,email',
            'password' => 'nullable|string|min:6|confirmed',
            'account_type' => 'nullable|string|exists:account_types,type'
        ];
        if (Str::lower($request->get('account_type')) == 'teacher'){
            $rules = array_merge($rules,[
                'phone' => 'filled|numeric|digits:10',
                'country' => 'filled|string|max:255',
                'organization_type' => 'filled|string|in:Further Education,Corporate Education,Government',
                'job_title' => 'filled|string|max:255',
                'school_organization' => 'filled|string|max:255',
            ]);
        }else if (Str::lower($request->get('account_type')) == 'student'){
            $rules = array_merge($rules,[
                'title' => 'nullable|string|max:255',
                'biography' => 'nullable|string|max:255',
            ]);
        }
        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }
        $model = User::query()
            ->where('id',$id)
            ->first();

        if($model){
            $model->update($request->all());
            if (Str::lower($request->get('account_type')) == 'teacher'){
                $model->teacherDetails()->first()->update($request->all());
            }elseif (Str::lower($request->get('account_type')) == 'teacher'){
                $model->studentDetails()->first()->update($request->all());
            }
        }

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $model
        ], 'update');
    }

    public function view(Request $request,$id){
        $model = User::with('studentDetails','teacherDetails')
            ->where('id',$id)
            ->first();
        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $model
        ], 'view');
    }

}
