<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Syllabus;
use App\Traits\ResponseTrait;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    use ResponseTrait, ValidatorTrait;

    public function create(Request $request){
        $rules = [
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:15',
            'syllabus' => 'nullable|string',
        ];

        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }
        $model = Course::create([
            'teacher_id' => $request->get('user')['id'],
            'title' => $request->get('title'),
            'code' => Str::upper($request->get('code')),
            'join_code' => Str::upper(Str::random(7))
        ]);

        $model->syllabus()->create([
           'syllabus' => $request->get('syllabus')
        ]);

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $model
        ], 'create');
    }

    public function read(Request $request){
        if ($request->get('user')['account_type'] == 'Student'){
            $result = Enrollment::query()
                ->where('user_id', $request->get('user')['id'])
                ->get();
        }else if ($request->get('user')['account_type'] == 'Teacher'){
            $result = Course::query()
                ->where('teacher_id',$request->get('user')['id'])
                ->get();
        }else{
            $result = Course::query()
                ->get();
        }

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $result
        ], 'read');
    }

    public function view(Request $request,$id){
        if ($request->get('type')){
            $result = DB::table('courses_to_syllabus')
                ->leftJoin('assignments','assignments.course_id','=','courses_to_syllabus.id')
                ->get();
        }

//        $result = Course::with('syllabus')
//            ->where('id',$id)
//            ->first();
        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $result
        ], 'view');
    }

    public function update(Request $request,$id){
        $rules = [
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:15',
            'syllabus' => 'nullable|string'
        ];

        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        $result = Course::where('id',$id)->update($request->only([
            'title',
            'code',
        ]));

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $result
        ], 'update');
    }

    //kurs silindiğinde ilişkili tüm kayıtlarda silinecek
    public function delete(Request $request,$id){

    }
}
