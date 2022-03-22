<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
      'course_id',
      'title',
      'due_date'
    ];

    protected $hidden = [
      'created_at',
      'updated_at'
    ];

    public function detail(){
        return $this->hasOne(AssignmentDetail::class);
    }
}
