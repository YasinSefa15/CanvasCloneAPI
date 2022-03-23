<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    use ResponseTrait;

    public function submitted($course_id,$file_id){
        $file = DB::table('submitted_files')
            ->where('id','=',$file_id)
            ->first();
        if (!is_null($file)){
            return Storage::download($file->file_path,$file->file_name);
        }
        return $this->responseTrait([
            'code' => null,
            'message' => "Dosya",
            'result' => null
        ],'download');
    }

    public function attached($course_id,$file_id){
        $file = DB::table('attached_files_to_assignments')
            ->where('id','=',$file_id)
            ->first();
        if (!is_null($file)){
            return Storage::download($file->file_path,$file->file_name);
        }

        return $this->responseTrait([
            'code' => null,
            'message' => "Dosya",
            'result' => null
        ],'download');
    }
}
