<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    // relasi ke booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // helper: cek apakah cage available
    public function isAvailable()
    {
        return $this->status === 'available';
    }
}