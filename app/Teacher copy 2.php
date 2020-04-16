<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable=[
        'first_name','last_name','dep_id','picture','cnic','status','date_of_birth','is_deleted'
        ,'user_id','phone'
    ];
}
