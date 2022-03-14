<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    use HasFactory;
    protected $table = 'student_to_details';

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    protected $fillable = [
        'user_id',
        'title',
        'biography'
    ];
}
