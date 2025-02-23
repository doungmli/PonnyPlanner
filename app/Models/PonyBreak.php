<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PonyBreak extends Model
{
    use HasFactory;
    protected $fillable = ['pony_id', 'start_time', 'end_time'];

    public function pony()
    {
        return $this->belongsTo(Pony::class);
    }
}
