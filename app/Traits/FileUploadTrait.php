<?php

namespace App\Traits;

use App\Models\AttachedFilesToAssignment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function detachFileFromAssignment(array $data){
        if ($data['file'] && Storage::exists($data['file']->file_path)){
            $result = $this->directoryClean($data['file']->file_path);
            $data['file']->delete();
            return "Dosya silme işlemi " . ($result ?  "başarılı." : "sırasında bir hata ile karşılaşıldı.");
        }
        return "Dosya silme işlemi başarısız.";
    }

    public function directoryClean(string $file_path){
        /** todo  : can delete parent directory later on */
        $result = Storage::delete($file_path);
        $parent_directory = Str::of($file_path)->dirname(1);
        if (is_null(Storage::files($parent_directory))){
            Storage::delete($parent_directory);
        }
        return $result;
    }
}
