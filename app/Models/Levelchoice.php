<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Questionlevel;

class Levelchoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer_text',
        'status',
        'questionlevel_id',
        'user_id'
    ];

    public  function question(){
        return $this->belongsTo(Questionlevel::class);
    }
}
