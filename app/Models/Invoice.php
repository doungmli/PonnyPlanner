<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'total_amount',
        'group_id',
        'reference',
        'status',
        'prix_unitaire_tvac'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function appointments()
    {
        return $this->hasManyThrough(Appointment::class, Group::class, 'id', 'group_id', 'group_id', 'id');
    }
}
