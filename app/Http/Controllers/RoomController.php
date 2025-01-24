<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
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

        // Validación de tipo, acomodación and amount
        if (!$this->isValidRoomType($request->room_type, $request->accommodation)) {
            return response()->json(['message' => 'Invalid combination of room type and accommodation'], 400);
        } else if (!$this->isValidNumberRooms($request->id_hotel, $request->amount)) {
            return response()->json(['message' => 'Total number of hotel rooms exceeded'], 400);
        }

        // Creating the new room
        $room = Room::create($validated); 
        return response()->json($room, 201);
    }

    private function isValidNumberRooms($id_hotel, $amount)
    {
        $amountsHotel = Room::where('id_hotel', $id_hotel)->get();

        $total = 0;

        foreach ($amountsHotel as $amountHotel) {
            $total += $amountHotel->amount;  
        }

        $totalAmounts = $total + $amount;

        $hotel = Hotel::find($id_hotel);
        
        return $totalAmounts <= $hotel->number_rooms;
    }
}
