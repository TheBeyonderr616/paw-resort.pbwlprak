<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Cage;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cage_id',
        'pet_name',
        'pet_type',
        'breed',
        'pet_photo',
        'reservation_date',
        'pawckage',
        'status',
    ];

    // ── RELASI USER ─────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── RELASI CAGE ─────────────────────────────
    public function cage()
    {
        return $this->belongsTo(Cage::class);
    }
}