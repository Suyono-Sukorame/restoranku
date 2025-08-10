<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('meja');
        if ($tableNumber) {
            Session::put('table_number', $tableNumber);
        }

        $items = Item::where('is_active', 1)->orderBy('name', 'asc')->get();

        return view('customer.menu', compact('items', 'tableNumber'));
    }

    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('customer.cart', compact('cart'));
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
                $imagePath = 'https://via.placeholder.com/150?text=No+Image';
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
        return redirect()->route('cart')->with('success', 'Keranjang berhasil dikosongkan');
    }

}
