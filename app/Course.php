<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable=[
        'is_deleted',
        'course_title',
        'course_title',
        'course_code',
        'uni_id',
        'credit_hr'];
}
