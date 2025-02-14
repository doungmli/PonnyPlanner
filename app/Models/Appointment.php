<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_date',
        'start_time',
        'end_time',
        'group_id',
        'assigned_ponies_count'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function ponies()
    {
        return $this->belongsToMany(Pony::class, 'appointment_pony');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'appointment_employee');
    }
}
