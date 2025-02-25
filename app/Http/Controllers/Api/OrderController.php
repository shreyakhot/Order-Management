<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class OrderController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return response()->json($order, 201);
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return response()->json($orders);
    }


    public function adminOrders()
    {
        $this->authorize('viewAny', Order::class); // Optional, for policy-based authorization
        $orders = Order::all();
        return response()->json($orders);
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorize('update', Order::class); // Optional, for policy-based authorization

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json($order);
    }
}
