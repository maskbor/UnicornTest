<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_action extends Model
{
    protected $primaryKey = ['user_id', 'action_id'];
    
    public $incrementing = false;
    public $timestamps = false;
}
