<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderList;
use App\Models\DetailOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        
        $timestamp = Carbon::now()->timestamp;
        $createdAt = Carbon::createFromTimestamp($timestamp)->toDateTimeString();
        $datetime = Carbon::now()->toDateTimeString();
        // Validate request
        $request->validate([
            'customer_name' => 'required',
            'order_type' => 'required',
            'order_date' => 'required|date',
            'order_detail' => 'required|array',
            'order_detail.*.coffee_id' => 'required',
            'order_detail.*.price' => 'required|numeric',
            'order_detail.*.quantity' => 'required|integer|min:1',
        ]);

        // Create order list
        $orderList = OrderList::create([
            'customer_name' => $request->customer_name,
            'order_type' => $request->order_type,
            'order_date' => $request->order_date,
            'createdAt' => $createdAt,
            'updatedAt' => $datetime,
        ]);

        // Create detail orders
        foreach ($request->order_detail as $detail) {
            $orderList->detailOrders()->create([
                'coffe_id' => $detail['coffee_id'],
                'price' => $detail['price'],
                'quantity' => $detail['quantity'],
                'createdAt' => $createdAt,
                'updatedAt' => $datetime,
            ]);
        }

        // Prepare response data
        $responseData = [
            'status' => true,
            'message' => 'Order has been created',
            'data' => $orderList,
        ];

        // Return JSON response
        return response()->json($responseData, 201);
    }

    public function index()
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }
        // Mengambil data order list dan detail order
        $orders = OrderList::with('detailOrders')->get();

        // Format data sesuai dengan respons yang diinginkan
        $responseData = [
            'status' => true,
            'data' => $orders,
            'message' => 'Order list has retrieved',
        ];

        // Kirim respons dalam format JSON
        return response()->json($responseData);
    } 
}