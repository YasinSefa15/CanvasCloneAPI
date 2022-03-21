<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    public $table = 'courses_to_syllabus';

    protected $fillable = [
      'course_id',
      'body'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
