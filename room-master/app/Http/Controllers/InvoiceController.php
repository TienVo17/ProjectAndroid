<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Invoice::orderByDesc('id')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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

            if ((Invoice::where('checkinout_id', $request->checkinout_id)->exists())) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Hóa đơn đã tồn tại'
                ], 400);
            }

            $new_invoice = new Invoice;
            $new_invoice->customer_id = Customer::where('email', $email)->first()->id;
            $new_invoice->checkinout_id = $request->checkinout_id;
            $new_invoice->is_payed = $request->is_payed;
            $new_invoice->note = $request->note;
            $new_invoice->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Tạo hóa đơn thành công'
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
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json([
                'status' => 'not found',
                'message' => 'hóa đơn thanh toán không tồn tại',
            ], 404);
        }

        return $invoice;
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
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json([
                'status' => 'not found',
                'message' => 'hóa đơn thanh toán không tồn tại',
            ], 404);
        }

        $invoice->method_id = $request->method_id;
        $invoice->checkinout_id = $request->checkinout_id;
        $invoice->note = $request->note;
        $invoice->is_payed = $request->is_payed;
        $invoice->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật hóa đơn thanh toán thành công',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json([
                'status' => 'not found',
                'message' => 'hóa đơn thanh toán không tồn tại',
            ], 404);
        }
        $invoice->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa hóa đơn thanh toán thành công'
        ], 200);
    }
}
