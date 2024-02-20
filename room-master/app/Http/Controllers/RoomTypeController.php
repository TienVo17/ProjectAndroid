<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RoomType::all();
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
        $new_room_type = new RoomType;
        $name = $request->name;

        if (RoomType::where('name', $name)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room Type này đã tồn tại'
            ], 400);
        }

        $new_room_type->name = $name;
        $new_room_type->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm mới loại phòng thành công'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room_type = RoomType::find($id);
        if (!$room_type) {
            return response()->json([
                'status' => 'not found',
                'message' => 'RoomType not found',
            ], 404);
        }
        return $room_type;
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
        $room_type = RoomType::find($id);
        if (!$room_type) {
            return response()->json([
                'status' => 'not found',
                'message' => 'RoomType not found',
            ], 404);
        }

        $room_type->name = $request->name;
        $room_type->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật loại phòng thành công',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room_type = RoomType::find($id);
        if (!$room_type) {
            return response()->json([
                'status' => 'not found',
                'message' => 'RoomType not found',
            ], 404);
        }

        $room_type_id = $room_type->id;
        $rooms = Room::where('room_type_id', $room_type_id)->get();

        if (($rooms->count()) > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'RoomType không thể xóa do có một số phòng đang là phòng loại này',
            ], 400);
        }

        $room_type->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa loại phòng thành công'
        ], 200);
    }
}
