<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama admin beserta metrik bisnis.
     */
    public function index()
    {
        // 1. Total Pendapatan
        // Praktik terbaik: Hanya hitung pesanan yang uangnya sudah masuk (paid, shipped, completed)
        // Kita abaikan pesanan yang masih 'pending' atau sudah 'cancelled'
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'completed'])
            ->sum('total_price');

        // 2. Total Pesanan
        // Menghitung seluruh transaksi yang masuk ke dalam sistem untuk melihat tren penjualan
        $totalOrders = Order::count();

        // 3. Alert Stok Menipis
        // Kita tentukan batas aman (threshold) stok, misalnya di bawah 5 unit dianggap kritis
        $stockThreshold = 5;
        
        // Hitung jumlah produk yang stoknya menipis untuk indikator angka
        $lowStockCount = Product::where('stock', '<', $stockThreshold)->count();
        
        // Ambil data produknya (maksimal 5 produk terbaru) untuk ditampilkan sebagai daftar ringkas di dashboard
        $lowStockProducts = Product::where('stock', '<', $stockThreshold)
            ->latest()
            ->take(5)
            ->get();

        // 4. Ringkasan User
        // Hanya menghitung pengguna dengan role 'user' (pelanggan), mengecualikan sesama akun admin
        $totalUsers = User::where('role', 'user')->count();

        // Mengirimkan seluruh variabel metrik ke view admin dashboard
        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'lowStockCount',
            'lowStockProducts',
            'totalUsers'
        ));
    }
}