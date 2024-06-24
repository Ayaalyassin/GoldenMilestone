<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkA1 extends Model
{
    use HasFactory;
    protected $table = 'mark_a1';
    protected $fillable = [
        'name',
        'phone_number',
        'project',
        'homework',
        'write',
        'final',
        'total'

    ];
}
