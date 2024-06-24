<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\level;

class Grammer extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'level_id'
        //'course_id'
    ];

    public function questions()
    {
       return $this->hasMany(Question::class,'grammer_id');
    }

    public  function level(){
        return $this->belongsTo(level::class);
    }
}
