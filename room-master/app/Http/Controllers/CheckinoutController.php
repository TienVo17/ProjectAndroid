<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkinout;
use App\Models\Customer;
use App\Models\Room;


class CheckinoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Checkinout::with('room')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $email = $request->email;
            if (!(Customer::where('email', $email)->exists())) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Khách hàng này không tồn tại'
                ], 400);
            }

            $room_id = $request->room_id;
            if (!(Room::where('id', $room_id)->exists())) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Phòng này không tồn tại'
                ], 400);
            }

            $check_in_out = new Checkinout;
            $check_in_out->room_id = $room_id;
            $check_in_out->customer_id = Customer::where('email', $email)->first()->id;
            $check_in_out->check_in = $request->check_in;
            $check_in_out->save();
            $room = Room::find($room_id);
            $room->is_active = true;
            $room->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Tạo thời gian checkin thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $check_in_out = Checkinout::find($id);
        if (!$check_in_out) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Thời gian check in/out không tồn tại',
            ], 404);
        }
        return $check_in_out;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $check_in_out = Checkinout::find($id);
        if (!$check_in_out) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Thời gian check in/out không tồn tại',
            ], 404);
        }

        $check_in_out->check_out = $request->check_out;
        $check_in_out->save();
        $room = Room::find($check_in_out->room_id);
        $room->is_active = false;
        $room->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật Checkout thành công',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
