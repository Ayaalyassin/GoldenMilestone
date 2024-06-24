<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PandingUser extends Model
{
    use HasFactory;
    protected $table = 'PandingUser';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
