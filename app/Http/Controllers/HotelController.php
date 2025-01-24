<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        // Get all hotels
        $hotels = Hotel::all();

        return response()->json($hotels);
    }

    public function create(Request $request)
    {
        // Validation of input data
        $validated = $request->validate([
            'name' => 'required|string|unique:hotels,name|max:200',
            'address' => 'required|string|max:150',
            'city' => 'required|string|max:100',
            'nit' => 'required|string|unique:hotels,nit|max:150',
            'number_rooms' => 'required|integer|min:1',
        ]);

        // Create new hotel
        $hotel = Hotel::create($validated);

        return response()->json($hotel, 201);
    }

    public function update(Request $request, $id)
    {
        // Validation of input data
        $validated = $request->validate([
            'name' => 'required|string|max:200|unique:hotels,name,' . $id,
            'address' => 'required|string|max:150',
            'city' => 'required|string|max:100',
            'nit' => 'required|string|max:150|unique:hotels,nit,' . $id,
            'number_rooms' => 'required|integer|min:1',
        ]);

        // Search for the hotel by its ID
        $hotel = Hotel::find($id);

        // If the hotel is not found, return a 404 error
        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        // Hotel update with new data
        $hotel->update($validated);

        return response()->json($hotel);
    }

    public function destroy($id)
    {

        $hotel = Room::destroy($id);

        // Search for the hotel by its ID
        $hotel = Hotel::find($id);

        // If the hotel is not found, return a 404 error
        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        $hotel->rooms()->delete();

        // Eliminating the hotel
        $hotel->delete();

        return response()->json(['message' => 'Hotel successfully removed'], 200);
    }
}
