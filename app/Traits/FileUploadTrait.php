<?php

namespace App\Traits;

use App\Models\AttachedFilesToAssignment;

trait FileUploadTrait
{

    public function attachFileToAssignment(array $data){
        $file_name = $data['file']->getClientOriginalName();
        $file_path = $data['file']->store('public/courses/'.$data['course_id'] . '/assignments/' .$data['assignment_id'] . '/attached_files');
        return AttachedFilesToAssignment::create([
           'assignment_id' => $data['assignment_id'],
           'file_path' => $file_path,
           'file_name' => $file_name
        ]);
    }


}
