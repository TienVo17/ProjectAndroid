<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\RoomType;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Room::get();
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
            $new_room = new Room;
            $new_room->name = $request->name;
            $room_type_id = $request->room_type_id;
            $new_room->price = $request->price;

            if (RoomType::where('id', $room_type_id)->exists()) {
                $new_room->room_type_id = $request->room_type_id;
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không có room type này'
                ], 400);
            }

            $new_room->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm mới phòng thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store2(Request $request){
        $new_room = new Room;
        $new_room->name = $request->query('name');
        $new_room->room_type_id = $request->query('room_type_id');
        $new_room->price = $request->query('price');
        $new_room->is_active = 0;
        $new_room->created_at = now();
        $new_room->updated_at = now();

        $new_room->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm mới phòng thành công'
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Room not found',
            ], 404);
        }
        return $room;
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
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Room not found',
            ], 404);
        }

        $room->name = $request->name;
        $room->room_type_id = $request->room_type_id;
        $room->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật phòng thành công',
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Room not found',
            ], 404);
        }

        $room->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa phòng thành công'
        ], 200);
    }
}
