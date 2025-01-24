<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Define the associated table
    protected $table = 'rooms';

    // Fields that can be mass assigned
    protected $fillable = [
        'id_hotel',
        'room_type',
        'accommodation',
        'amount',
    ];

    // Relationship with the Hotel model (A hotel has many rooms)
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotel');
    }
}
