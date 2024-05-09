<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\order_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class transaksi extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }
    //tambah item
    public function tambahItem(Request $req, $id)
    {
        $data = $req->json()->all();

        foreach ($data as $item) {
            $validator = Validator::make($item, [
                'id_produk' => 'required',
                'jumlah' => 'required',
                'price' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $save = order_detail::create([
                'coffe_id' => $item['id_produk'],
                'quantity' => $item['jumlah'],
                'order_id' => $id,
                'price' => $item['price'],
            ]);

            if (!$save) {
                return response()->json(['success' => false]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Sukses menambahkan pesanan']);
    }
    //order baru
    public function order(request $req){
        $validator = Validator::make($req->all(), [
            'customer' => 'required',
            'type' => 'required',
            'order_date'=>'required'
            
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $save = order::create([
            'customer_name' => $req->input('customer'),
            'order_type' => $req->input('type'),
            'order_date' => $req->input('order_date')
        ]);
        if ($save) {
            return response()->json(['success' => true, 'order_id' => $save->id, 'message' => 'Order created successfully'], 201);
        } else {
            return response()->json(['success' => false, 'message' =>'gagal']);
        }
    }
    // get order
    public function getdetail($id)
    {
       $order=order::where('id', $id)->get();
       $detail = order_detail::where('id_order',$id)->get();

       $gather = $order->map(function($orderer) use ($detail){
        $orderer->setAttribute('order_detail', $detail);
        return $orderer;
       });

       $response=[
        'status'=> true,
        'data' => $gather,
        "message"=>'Order list has retrivied'
       ];
        return response()->json($response);
        
      
    
}
public function getdetailall()
{
   $order=order::get();
   $detail = order_detail::get();

   $gather = $order->map(function($orderer) use ($detail){
    $orderer->setAttribute('order_detail', $detail);
    return $orderer;
   });

   $response=[
    'status'=> true,
    'data' => $gather,
    "message"=>'Order list has retrivied'
   ];
    return response()->json($response);
    
  

}
}
//     public function getdetail($id)
//     {
//         $dt_produk = order_detail::where('id_order', $id)->get();
//         return response()->json($dt_produk);
//     }

//     public function getOrder(){
//         $dt = order::get();
//         return response()->json($dt);
//     }
// }