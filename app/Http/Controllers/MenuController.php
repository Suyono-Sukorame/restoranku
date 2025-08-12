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
            return redirect()->route('checkout')->withErrors($validator);
        }

        // Hitung total
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['qty'];
        }

        // Buat user
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

        // Buat order
        $order = Order::create([
            'order_code' => 'ORD-' . $tableNumber . '-' . time(),
            'user_id' => $user->id,
            'subtotal' => $totalAmount,
            'tax' => $totalAmount * 0.1,
            'grand_total' => $totalAmount + ($totalAmount * 0.1),
            'status' => 'pending',
            'table_number' => $tableNumber,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // Buat order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'] * $item['qty'],
                'tax' => $item['price'] * $item['qty'] * 0.1,
                'total_price' => ($item['price'] * $item['qty']) + (0.1 * $item['price'] * $item['qty']),
            ]);
        }

        Session::forget('cart');

        if ($request->payment_method == 'tunai') {
            return redirect()->route('checkout.success', ['orderId' => $order->order_code])
                            ->with('success', 'Pesanan berhasil dibuat. Silakan bayar di kasir.');
        } else {
            \Midtrans\Config::$serverKey = config('midtrans.SERVER_KEY');
            \Midtrans\Config::$isProduction = config('midtrans.IS_PRODUCTION');
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Buat array item details dari cart
            $itemDetails = [];
            foreach ($cart as $item) {
                $itemDetails[] = [
                    'id' => $item['id'],
                    'price' => (int) $item['price'],
                    'quantity' => $item['qty'],
                    'name' => $item['name'],
                ];
            }
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => (int) $order->grand_total,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => $user->fullname ?? 'Guest',
                    'phone' => $user->phone,
                ],
                'enabled_payments' => ['qris', 'gopay', 'shopeepay'], // Tambahkan ini
                'payment_type' => 'qris',
                'qris' => [ // Tambahkan konfigurasi khusus QRIS
                    'acquirer' => 'gopay' // atau 'shopeepay', 'nobu', dll
                ]
            ];

            // $params = [
            //         'transaction_details' => [
            //         'order_id' => $order->order_code,
            //         'gross_amount' => (int) $order->grand_total,
            //     ],
            //         'item_details' => $itemDetails,
            //         'customer_details' => [
            //         'first_name' => $user->fullname ?? 'Guest',
            //         'phone' => $user->phone,
            //     ],
            //         'payment_type' => 'qris',
            // ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                // Misal kamu pakai AJAX, return json
                return response()->json([
                    'status' => 'success',
                    'snap_token' => $snapToken,
                    'order_code' => $order->order_code,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal membuat transaksi Midtrans: ' . $e->getMessage(),
                ]);
            }
        }
    }

    public function checkoutSuccess($orderId)
    {
        $order = Order::where('order_code', $orderId)->first();
        if (!$order) {
            return redirect()->route('menu')->with('error', 'Pesanan tidak ditemukan');
        }
        
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        
        return view('customer.success', compact('order', 'orderItems'));
    }
}
