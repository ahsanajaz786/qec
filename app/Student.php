<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable=[
        'first_name','last_name','program_id','picture','roll_number','session_id','status','date_of_birth','is_deleted'
        ,'user_id'
    ];
}


