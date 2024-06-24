<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    use HasFactory;
    protected $table = 'pdfs';
    protected $fillable = [
        'file_name',
        'path',
        'course_id',
    ];
    public function course(){
        return $this ->belongsTo('App\Models\Course','course_id');
    }
}
