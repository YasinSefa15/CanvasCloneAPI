<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDetail extends Model
{
    use HasFactory;
    protected $table = 'teacher_to_details';

    protected $hidden = [
        'updated_at',
        'created_at'
    ];
    protected $fillable = [
        'user_id',
        'phone',
        'country',
        'organization_type',
        'job_title',
        'school_organization',
    ];
}
