<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cage extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
