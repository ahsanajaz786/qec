<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeahcerCourse extends Model
{
    protected $fillable=[
        'teacher_id','course_id','status','program_session_id'
        
    ];
}
