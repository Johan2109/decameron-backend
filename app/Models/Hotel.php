<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // Define the related table
    protected $table = 'hotels';

    // Fields that can be mass assigned
    protected $fillable = [
        'name', 
        'address', 
        'city', 
        'nit', 
        'number_rooms'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'id_hotel'); 
    }
}
