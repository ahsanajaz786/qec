<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'id','program_name',
        'dep_id', 'uni_id',
        'is_deleted'
        ];
}
