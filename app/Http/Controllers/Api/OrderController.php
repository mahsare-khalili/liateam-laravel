<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    
    public function create(Request $request)
    {
        $this->validate($request,
        [
            'total_price' => 'required',
            'count' => 'required',
            'products' => 'required',
        ]);

        $this->authUser();

        $order = Order::create($request->only(['total_price', 'count', 'products']));

        return response()->json(compact('order'));
    }

    public function all()
    {
        $this->authUser();
        
        return Order::all();
    }

    public function update(Request $request, Order $order)
    {
        $this->authUser();

        $order->update($request->only(['total_price', 'count', 'products']));

        return response()->json(compact('order'));
    }

    public function show(Order $order)
    {
        $this->authUser();

        return response()->json(compact('order'));
    }

    public function delete(Order $order)
    {
        $this->authUser();

        $order->delete();
    }
}
