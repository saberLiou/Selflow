<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * Images storage path.
     * @var array
     */
    public $directory = "images";

    protected $fillable = ['file'];

    /**
     * Reset images' file path after pulling it out of database.
     * Accessor function
     * @return modified file path
     */
    public function getFileAttribute($value){
        return "/".$this->directory."/".$value;
    }

    public function user(){
        return $this->hasOne('App\User');
    }

    public function post(){
        return $this->hasOne('App\Post');
    }
}
