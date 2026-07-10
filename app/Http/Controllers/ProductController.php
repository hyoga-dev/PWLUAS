<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk di halaman depan (Katalog/Home).
     */
    public function index()
    {
        // Mengambil produk terbaru untuk ditampilkan di grid koleksi
        $products = Product::latest()->get();

        return view('home', compact('products'));
    }

    /**
     * Menampilkan halaman detail produk berdasarkan slug.
     */
    public function show($slug)
    {
        // Mencari produk berdasarkan slug, jika tidak ada akan melempar error 404
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('product.show', compact('product'));
    }
}