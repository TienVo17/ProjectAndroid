<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRoom;
use App\Models\Customer;
use App\Models\Room;


class BookingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BookingRoom::with('customer', 'room')->orderByDesc('id')->paginate(10);
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
            $new_book = new BookingRoom;
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

            $check_in_date = $request->input('check_in_date');
            $check_out_date = $request->input('check_out_date');

            // Kiểm tra xem phòng có sẵn trong khoảng ngày đặt không
            $isRoomAvailable = BookingRoom::where('room_id', $room_id)
                ->where(function ($query) use ($check_in_date, $check_out_date) {
                    $query->whereBetween('check_in_date', [$check_in_date, $check_out_date])
                        ->orWhereBetween('check_out_date', [$check_in_date, $check_out_date])
                        ->orWhere(function ($query) use ($check_in_date, $check_out_date) {
                            $query->where('check_in_date', '<=', $check_in_date)
                                ->where('check_out_date', '>=', $check_out_date);
                        });
                })->exists();
            
            if ($isRoomAvailable) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Phòng đã được book trong thời gian này'
                ], 400);
            }
            $customer_id = Customer::where('email', $email)->first()->id;
            $new_book->room_id = $room_id;
            $new_book->customer_id = $customer_id;
            $new_book->booking_date = now();
            $new_book->check_in_date = $check_in_date;
            $new_book->check_out_date = $check_out_date;
            $new_book->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Book phòng thành công'
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
        $book_room = BookingRoom::find($id);
        if (!$book_room) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Thời gian book phòng này không tồn tại',
            ], 404);
        }
        return $book_room;
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
        $book_room = BookingRoom::find($id);
        if (!$book_room) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Thời gian book phòng này không tồn tại',
            ], 404);
        }

        $check_in_date = $request->input('check_in_date');
        $check_out_date = $request->input('check_out_date');

        // Kiểm tra xem phòng có sẵn trong khoảng ngày đặt không
        $isRoomAvailable = BookingRoom::where('room_id', $book_room->room_id)->where('id', '<>', $id)
            ->where(function ($query) use ($check_in_date, $check_out_date) {
                $query->whereBetween('check_in_date', [$check_in_date, $check_out_date])
                    ->orWhereBetween('check_out_date', [$check_in_date, $check_out_date])
                    ->orWhere(function ($query) use ($check_in_date, $check_out_date) {
                        $query->where('check_in_date', '<=', $check_in_date)
                            ->where('check_out_date', '>=', $check_out_date);
                    });
            })->exists();
        
        if ($isRoomAvailable) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng đã được book trong thời gian này'
            ], 400);
        }

        $book_room->check_in_date = $check_in_date;
        $book_room->check_out_date = $check_out_date;
        $book_room->booking_date = now();
        $book_room->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật book phòng thành công',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book_room = BookingRoom::find($id);
        if (!$book_room) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Thời gian book phòng này không tồn tại',
            ], 404);
        }
        $book_room->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa lịch sử book phòng thành công'
        ], 200);
    }
}
