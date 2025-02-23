<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['last_name', 'first_name', 'role', 'email'];

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_employee');
    }
}
