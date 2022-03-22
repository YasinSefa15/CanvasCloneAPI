<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'join_code',
        'code',
        'title'
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function syllabus(){
        return $this->hasOne(Syllabus::class);
    }
}
