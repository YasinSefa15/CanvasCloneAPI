<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedFile extends Model
{
    use HasFactory;

    public $table = 'submitted_files';

    protected $fillable = [
        'assignment_id',
        'user_id',
        'file_path',
        'file_name'
    ];
}
