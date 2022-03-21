<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachedFilesToAssignment extends Model
{
    use HasFactory;

    public $table = 'attached_files_to_assignments';

    protected $fillable = [
      'assignment_id',
      'file_path',
      'file_name'
    ];

    protected $hidden = [
      'created_at',
      'updated_at'
    ];
}
