<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan daftar item yang ada di keranjang user.
     */
    public function index()
    {
        // Menggunakan eager loading ('product') untuk menghemat query database
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        // Menghitung total harga dari seluruh item di keranjang
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Menambahkan produk ke dalam keranjang belanja.
     */
    public function store(Request $request, Product $product)
    {
        // Validasi input kuantitas
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek apakah produk ini sudah pernah dimasukkan ke keranjang oleh user terkait
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingCart) {
            // Jika sudah ada, cukup update/tambahkan kuantitasnya
            $existingCart->increment('quantity', $request->quantity);
        } else {
            // Jika belum ada, buat baris data baru di tabel carts
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Action figure berhasil ditambahkan ke keranjang.');
    }

    /**
     * Menghapus item tertentu dari keranjang belanja.
     */
    public function destroy(Cart $cart)
    {
        // Memastikan keaktifan sesi: user hanya bisa menghapus item keranjang miliknya sendiri
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak sah.');
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}