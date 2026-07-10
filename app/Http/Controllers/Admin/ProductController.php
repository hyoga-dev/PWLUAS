<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk di halaman admin.
     */
    public function index()
    {
        // Mengambil produk terbaru dengan pagination (misal 10 data per halaman)
        $products = Product::latest()->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Ketat
        $request->validate([
            'name'          => 'required|string|max:255|unique:products,name',
            'description'   => 'nullable|string',
            'material_size' => 'nullable|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0', // Memastikan stok berupa angka bulat positif
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB, tipe sesuai request
        ]);

        // 2. Inisialisasi Data
        $data = $request->only(['name', 'description', 'material_size', 'price', 'stock']);
        
        // Auto-generate slug unik dari nama produk
        $data['slug'] = Str::slug($request->name);

        // 3. Handling Upload Gambar ke Folder Storage
        if ($request->hasFile('image')) {
            // Menyimpan di storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_path'] = $imagePath;
        }

        // 4. Simpan ke Database
        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Action figure baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail produk tertentu (opsional untuk admin).
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Menampilkan form edit untuk produk tertentu.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi Input (Kecualikan ID saat ini untuk pengecekan unik nama)
        $request->validate([
            'name'          => 'required|string|max:255|unique:products,name,' . $product->id,
            'description'   => 'nullable|string',
            'material_size' => 'nullable|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'material_size', 'price', 'stock']);
        $data['slug'] = Str::slug($request->name);

        // 2. Handling Perubahan Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage fisik jika ada
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Simpan gambar yang baru
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_path'] = $imagePath;
        }

        // 3. Update Database
        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Data action figure berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari database beserta gambarnya.
     */
    public function destroy(Product $product)
    {
        // 1. Hapus file gambar fisik dari storage agar tidak memenuhi server
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        // 2. Hapus baris data dari database
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Action figure berhasil dihapus dari sistem.');
    }
}