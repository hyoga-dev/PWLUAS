<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan masuk untuk admin.
     */
    public function index()
    {
        // Menggunakan eager loading ('user') untuk menghindari N+1 query problem
        $orders = Order::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan spesifik.
     */
    public function show(Order $order)
    {
        // Memuat relasi user agar informasi pemesan bisa ditampilkan di detail
        $order->load('user');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status transaksi dan pengiriman (termasuk nomor resi).
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1. Validasi input status berdasarkan enum di database
        $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'paid', 'shipped', 'completed', 'cancelled']),
            ],
            'tracking_number' => 'nullable|string|max:100', // Untuk menyimpan nomor resi
        ]);

        // 2. Perbarui data di database
        // Catatan: Jika Anda ingin menyimpan nomor resi secara fisik, pastikan kolom 'tracking_number' 
        // sudah ditambahkan ke tabel 'orders' melalui migration.
        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number, 
        ]);

        // 3. Logika otomatisasi tambahan (Opsional namun direkomendasikan):
        // Jika status diubah menjadi 'cancelled', Anda bisa menambahkan logika di sini 
        // untuk mengembalikan stok action figure yang sebelumnya terpotong.

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}