<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentPony extends Model
{

    use HasFactory;

    protected $fillable = ['appointment_id', 'pony_id'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pony()
    {
        return $this->belongsTo(Pony::class);
    }
}
