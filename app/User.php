<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'photo_id', 'role_id', 'is_active', 'name', 'email', 'password', 'pwd_num'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function photo(){
        return $this->belongsTo('App\Photo');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function replies(){
        return $this->hasMany('App\CommentReply');
    }

    public function isAdmin(){
        return $this->role->name == "administrator" and $this->is_active == 1;
    }

    public function isAuthor(){
        return $this->role->id <= 2 and $this->is_active == 1;
    }
}
