<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('meja');
        if ($tableNumber) {
            Session::put('table_number', $tableNumber);
        }

        $items = Item::where('is_active', 1)
                    ->orderBy('name', 'asc')
                    ->get();

        return view('customer.menu', compact('items', 'tableNumber'));
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        $tableNumber = Session::get('table_number');
        return view('customer.cart', compact('cart', 'tableNumber'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('id');
        $menu = Item::find($menuId);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan'
            ]);
        }

        $imagePath = $menu->img;

        if (empty($imagePath)) {
            $imagePath = 'https://via.placeholder.com/150?text=No+Image';
        }
        if (!filter_var($imagePath, FILTER_VALIDATE_URL)) {
            $fullPath = public_path('img_item_upload/' . $imagePath);
            if (!file_exists($fullPath)) {
                $imagePath = 'https://source.unsplash.com/150x150/?food';
            }
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += 1;
        } else {
            $cart[$menuId] = [
                'id'    => $menu->id,
                'name'  => $menu->name,
                'price' => $menu->price,
                'image' => $imagePath,
                'qty'   => 1
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan menu ke keranjang',
            'cart' => $cart
        ]);
    }

    public function updateCart(Request $request)
    {
        $itemId = $request->input('id');
        $newQty = (int) $request->input('qty');

        if ($newQty < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah minimal 1'
            ]);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['qty'] = $newQty;
            Session::put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Jumlah item berhasil diperbarui'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan di keranjang'
        ]);
    }

    public function removeCart($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            Session::flash('success', 'Item berhasil dihapus dari keranjang');
        }
        return redirect()->route('cart');
    }

    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->route('cart')
                         ->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function checkout()
    {
        $cart = Session::get('cart');
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang masih kosong');
        }
        $tableNumber = Session::get('table_number');
        return view('customer.checkout', compact('cart', 'tableNumber'));
    }

    public function storeOrder(Request $request)
    {
        $cart = Session::get('cart');
        $tableNumber = Session::get('table_number');
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang masih kosong');
        }
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',            
        ]);
        if ($validator->fails()) {
            return redirect()->route('checkout')
                             ->withErrors($validator);
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $totalAmount = 0;
        $itemDetails = [];
        foreach ($cart as $item) {
            $totalAmount += $item['qty'] * $item['price'];

            $itemDetails[] = [
                'id' => $item['id'],
                'price' => (int) $item['price'] + ($item['price'] * 0.1),
                'quantity' => $item['qty'],
                'name' => substr($item['name'], 0, 50), 
            ];
        }
        $user = User::firstOrCreate(
            [
                'fullname' => $request->input('fullname'),
                'phone'    => $request->input('phone'),
                'role_id'  => 4
            ],
            [
                'username' => strtolower(str_replace(' ', '', $request->input('fullname'))) . rand(100, 999),
                'email'    => strtolower(str_replace(' ', '', $request->input('fullname'))) . rand(100, 999) . '@example.com'
            ]
        );

        $order = Order::create([
            'order_code' => 'ORD-' . $tableNumber . '-' . time(),
            'user_id' => $user->id,
            'subtotal' => $totalAmount,
            'tax' => $totalAmount * 0.1, // Assuming 10%
            'grand_total' => $totalAmount + (0.1 * $totalAmount),
            'status' => 'pending',
            'table_number' => $tableNumber,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'] * $item['qty'],
                'tax' => $item['price'] * $item['qty'] * 0.1,
                'total_price' => ($item['price'] * $item['qty']) + (0.1 * $item[ 'price'] * $item['qty']),
            ]);
        }

        Session::forget('cart');

        return redirect()->route('menu')
                         ->with('success', 'Pesanan berhasil dibuat');
    }
}
