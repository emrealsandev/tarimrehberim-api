<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;
use App\Models\Order;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Admin panelinde siparişleri görüntülemek için
        $data = Order::all();
        $response = [
            'success' => true,
            'data' => OrderResource::collection($data),
            'message' => 'Orders Fetched'
        ];
        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        // Sipariş verme eklemeleri var

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'address' => 'required|string',
            'count' => 'required',
        ]);

        if($validator->fails()){
            return response->json($validator->errors());
        }



        $order = Order::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'address' => $request->address,
            'count' => $request->count,
            'product_id' => $request->product_id,
        ]);

        return response()->json(['Sipariş Başarılı', new OrderResource($order)],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // Admin panelinden silme işlemi
        $order->delete();

        return response()->json('Sipariş Başarıyla Silindi.');
    }
}
