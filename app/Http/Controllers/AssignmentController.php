<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Traits\FileUploadTrait;
use App\Traits\ResponseTrait;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    use ResponseTrait, ValidatorTrait, FileUploadTrait;

    public function create(Request $request,$course_id){
        $rules = [
            'title' => 'required|string|max:255',
            'due_date' => 'required||date_format:Y-m-d H:i',
            'body' => 'required|max:65535',
            'file' => 'nullable|mimes:pdf,rar,docx,txt'
        ];

        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        $model = Assignment::create([
            'title' => $request->get('title'),
            'due_date' => $request->get('due_date'),
            'course_id' => $course_id,
        ]);

        $model->detail()->create([
            'body' => $request->get('body')
        ]);

        $model->detail = $model->detail()->first();

        if($file = $request->file('file')){
            $model->file = $this->attachFileToAssignment([
                'file' => $file,
                'course_id' => $course_id,
                'assignment_id' => $model->id
            ]);
        }

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $model
        ], 'create');
    }


    public function read(Request $request,$course_id){
        $result = DB::table('assignments')
            ->where('course_id','=',$course_id)
            ->get();

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $result
        ], 'read');
    }
}
