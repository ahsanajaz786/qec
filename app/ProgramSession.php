<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramSession extends Model
{
    protected $fillable=[
        'pro_id',
        'semester',
        'session_id',
        'status'
        ]
  ;
}

