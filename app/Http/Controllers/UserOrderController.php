<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        // Mengambil data relasi orders milik user yang sedang aktif
        // Diurutkan menggunakan latest() (berdasarkan created_at terbaru)
        $orders = Auth::user()->orders()
            ->latest()
            ->get();

        // Mengembalikan ke folder views/orders/index.blade.php
        return view('orders.index', compact('orders'));
    }
}