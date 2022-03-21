<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
            'syllabus' => 'nullable|string'
        ];

        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        /** todo : user_id tokenla işlem yapan kullanıcıdan gelecek */
        $model = Course::create([
            'title' => $request->get('title'),
            'code' => Str::upper($request->get('code')),
            'join_code' => Str::upper(Str::random(7)),
            'user_id' => $request->get('user_id')
        ]);

        DB::table('courses_to_syllabus')
            ->insert([
                'course_id' => $model->id,
                'syllabus' => $request->get('syllabus'),
            ]);

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $model
        ], 'create');
    }

    /** todo : kaldım burada .d */
    //Kullanıcının kayıtlı olduğu kurslar. Ve kullanıcının açtığı kurslar
    public function read(Request $request){
        $request->attributes->add(
            ['user'  => [
                'id' => 2,
                'account_type' => 'Student'
        ]]
        );
        $user_id = $request->get('user')['id'];
        $result = DB::table('courses')
            ->when($request->get('user')['account_type'] == 'Student', function ($query,$user_id){
                $query->where('student_to_courses.student_id','=',$user_id);
            })
        ->get();

        return $this->responseTrait([
            'code' => null,
            'message' => $request->route()->getName(),
            'result' => $result
        ], 'read');
    }

    public function update(Request $request,$id){
        $rules = [
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:15',
            'syllabus' => 'nullable|string',
            "file" => "nullable|mimes:pdf|max:10000"
        ];

        $validation = $this->validator($request->all(),$rules);
        if (isset($validation)){
            return $validation;
        }

        $result = Course::where('id',$id)->update($request->all());

        if ($request->get('file')){
            dd("yes");
        }

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
