<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AttachedFilesToAssignment;
use App\Models\SubmittedFile;
use App\Traits\FileUploadTrait;
use App\Traits\ResponseTrait;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, $course_id,$assignment_id){
        $rules = [
            'title' => 'nullable|string|max:255',
            'due_date' => 'nullable||date_format:Y-m-d H:i',
            'body' => 'nullable|max:65535',
            'file_operation' => 'nullable|string|in:delete,upload',
            'file' => 'nullable|mimes:pdf,rar,docx,txt|max:5120'
        ];
        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        $model = Assignment::query()
            ->where('id',$assignment_id);

        $model->update($request->only([
                'title',
                'due_date'
            ]));

        $result = $model->first();

        /** todo : cant add more than one file check it. */
        if ($result &&($operation = $request->get('file_operation'))){
            if ($operation == 'delete'){
                $result->file_status = $this->detachFileFromAssignment([
                    'file' => $model->first()->attachedFile()->first(),
                    'course_id' => $course_id,
                    'assignment_id' => $assignment_id
                ]);
            }else if ($operation == 'upload' && ($file = $request->file('file'))){
                $result->file_status = $this->attachFileToAssignment([
                        'file' => $file,
                        'course_id' => $course_id,
                        'assignment_id' => $assignment_id
                    ]);
            }
        }
        if ($request->get('body')){
            $detail = $model->first()->detail()->first();
            $detail->update($request->only([
                'body'
            ]));
            $result->asignments_details = $detail;
        }

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $result
        ], 'update');
    }

    public function view(Request $request){
        dd("view");
    }

}
