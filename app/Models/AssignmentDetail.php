<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentDetail extends Model
{
    use HasFactory;

    public $table = 'assignment_details';

    protected $fillable = [
        'assignment_id',
        'body'
    ];

    protected $hidden = [
      'created_at',
      'updated_at'
    ];
}
