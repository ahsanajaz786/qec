<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable=[
        'department_name',
        'faculty_id','is_deleted']
  ;
}
