<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index($idHotel)
    {
        // Get hotel rooms
        $rooms = Room::where('id_hotel', $idHotel)->get();
        return response()->json($rooms);
    }

    private function isValidRoomType($room_type, $accommodation)
    {
        $validTypes = [
            'ESTANDAR' => ['SENCILLA', 'DOBLE'],
            'JUNIOR' => ['TRIPLE', 'CUADRUPLE'],
            'SUITE' => ['SENCILLA', 'DOBLE', 'TRIPLE'],
        ];

        return in_array($accommodation, $validTypes[$room_type] ?? []);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'id_hotel' => 'required',
            'room_type' => 'required|in:ESTANDAR,JUNIOR,SUITE', // Valid values ​​for 'room type'
            'accommodation' => 'required|in:SENCILLA,DOBLE,TRIPLE,CUADRUPLE', // Valid values ​​for 'accommodation'
            'amount' => 'required|integer|min:1',
        ]);

        // Validación de tipo y acomodación
        if (!$this->isValidRoomType($request->room_type, $request->accommodation)) {
            return response()->json(['message' => 'Invalid combination of room type and accommodation'], 400);
        }

        // Creating the new room
        $room = Room::create($validated); 
        return response()->json($room, 201);
    }
}
