<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customer::get();
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
        try{
            $new_customer = new Customer;
            $email = $request->email;
            if (Customer::where('email', $email)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email này đã tồn tại'
                ], 400);
            }

            $new_customer->username = $request->username;
            $new_customer->address = $request->address;
            $new_customer->email = $email;
            $new_customer->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm mới khách hàng thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Khách hàng không tồn tại',
            ], 404);
        }
        return $customer;
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
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Khách hàng không tồn tại',
            ], 404);
        }

        $customer->username = $request->username;
        $customer->address = $request->address;
        $customer->email = $request->email;
        $customer->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật khách hàng thành công',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status' => 'not found',
                'message' => 'Khách hàng không tồn tại',
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa khách hàng thành công'
        ], 200);
    }
}
