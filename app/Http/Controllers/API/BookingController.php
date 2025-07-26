<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;


class BookingController extends Controller
{
    public function store(Request $req)
    {
        $data = $req->validate([
            'bookable_type' => 'required|in:tool,room',
            'bookable_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'purpose' => 'nullable|string'
        ]);

        $typeMap = [
            'tool' => \App\Models\Tool::class,
            'room' => \App\Models\Room::class
        ];

        return Booking::create([
            'user_id' => $req->user()->id,
            'bookable_type' => $typeMap[$data['bookable_type']],
            'bookable_id' => $data['bookable_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'purpose' => $data['purpose'],
            'status' => 'pending'
        ]);
    }
}
