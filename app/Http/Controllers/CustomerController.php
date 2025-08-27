<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Feedback;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role_id', 4)
                        ->withCount('orders')
                        ->with(['orders' => function($q) {
                            $q->selectRaw('user_id, SUM(grand_total) as total_spent, COUNT(*) as order_count')
                              ->groupBy('user_id');
                        }])
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        
        return view('admin.customer.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $orders = $customer->orders()->with('orderItems.item')->orderBy('created_at', 'desc')->get();
        $totalSpent = $customer->orders()->sum('grand_total');
        $feedbacks = $customer->feedbacks()->with('order')->latest()->get();
        
        return view('admin.customer.show', compact('customer', 'orders', 'totalSpent', 'feedbacks'));
    }

    public function feedback()
    {
        $feedbacks = Feedback::with(['user', 'order'])->orderBy('created_at', 'desc')->paginate(20);
        $avgRating = Feedback::avg('rating');
        
        return view('admin.customer.feedback', compact('feedbacks', 'avgRating'));
    }
}