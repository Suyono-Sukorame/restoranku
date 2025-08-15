<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::all();
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('orderItems.item')->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    public function settlement($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'settlement';
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order settled successfully.');
    }
}
