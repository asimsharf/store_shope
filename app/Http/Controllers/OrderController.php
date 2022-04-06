<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $order = Order::with(['customer'])->get();
            return $this->success(1,  $order);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $order = new Order();

            $order->customer_id = $request->customer_id;
            $order->order_date = $request->order_date;
            $order->save();

            $order_product=new OrderProduct();

            foreach ($request->products as $item) {
                $order_product::create([
                    'order_id'=>$order->id,
                    'product_id'=>$item['product_id'],
                    'quantity'=>$item['quantity']
                ]);
            }

            if($order_product){
            
                return $this->success(1,  $order);
                
            }else{
                return $this->error(0,'can not create order');
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return $this->error(2, 'Duplicate Exception ');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
