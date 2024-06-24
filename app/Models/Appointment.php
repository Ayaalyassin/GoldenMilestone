<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'date_appointment',
        'time_appointment',
        'place_appointment',
        'status'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class,'appointment_id');
    }

    protected $primarykey='id';
    public $timestamps=true;
}
