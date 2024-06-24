<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Grammer;

class level extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'text',
        'user_id'
    ];

    public function grammers()
    {
        return $this->hasMany(Grammer::class,'level_id');
    }

    public  function user(){
        return $this->belongsTo(User::class);
    }


}

