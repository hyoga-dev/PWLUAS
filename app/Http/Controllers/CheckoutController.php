<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman ringkasan checkout dan form alamat.
     */
    public function index()
    {
        // Mengambil seluruh item di keranjang user beserta data produknya
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        // Proteksi: Jika keranjang kosong, kembalikan ke halaman cart
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        // Menghitung total akhir yang harus dibayar
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Memproses data checkout dan membuat pesanan baru.
     */
    public function process(Request $request)
    {
        // Validasi input alamat pengiriman
        $request->validate([
            'shipping_address' => 'required|string|min:10',
        ]);

        // Mengambil kembali data keranjang untuk diproses
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item untuk di-checkout.');
        }

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Memulai Database Transaction demi keamanan data keuangan & stok
        DB::beginTransaction();

        try {
            // 1. Buat baris data baru di tabel orders
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'status' => 'pending', // Status awal sebelum dibayar
            ]);

            // 2. Validasi dan kurangi stok masing-masing action figure
            foreach ($cartItems as $item) {
                $product = $item->product;

                // Cek apakah stok fisik mencukupi permintaan
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok untuk figur '{$product->name}' tidak mencukupi.");
                }

                // Kurangi stok produk menggunakan metode decrement bawaan Eloquent
                $product->decrement('stock', $item->quantity);
            }

            // 3. Bersihkan keranjang belanja user karena sudah sukses dipesan
            Cart::where('user_id', Auth::id())->delete();

            // Jika semua proses di atas berhasil tanpa error, simpan permanen ke database
            DB::commit();

            return redirect()->route('home')->with('success', 'Pesanan Anda berhasil dibuat! Silakan lanjut ke pembayaran.');

        } catch (\Exception $e) {
            // Jika ada satu saja proses yang gagal (misal: stok habis tiba-tiba), batalkan semua perubahan
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal memproses checkout: ' . $e->getMessage())
                ->withInput();
        }
    }
}