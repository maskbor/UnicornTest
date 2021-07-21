<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'second_name', 'first_name', 'middle_name', 'email'
    ];

    public function login_sources()
    {
        return $this->hasMany(Login_source::class);
    }
    
    public function actions()
    {
        return $this->belongsToMany(Action::class, 'user_actions');
    }

}
