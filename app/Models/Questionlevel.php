<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Answerlevel;
use App\Models\Levelchoice;

class Questionlevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_text',
        //'user_id'
    ];

    public function answers(){
        return $this->hasMany(Answerlevel::class,'questionlevel_id','id');
    }

    public function levelchoices(){
        return $this->hasMany(Levelchoice::class,'questionlevel_id','id');
    }

    /*public  function user(){
        return $this->belongsTo(User::class);
    }*/


}

