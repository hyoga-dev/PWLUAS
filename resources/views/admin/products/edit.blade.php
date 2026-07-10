<x-admin-layout>
    <x-slot name="title">Edit Produk - {{ $product->name }}</x-slot>

    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-xs font-semibold text-gray-400 hover:text-gray-950 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path></svg>
            Kembali ke Inventaris
        </a>
    </div>

    <div class="mb-12">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Modifikasi Data Produk</h1>
        <p class="text-sm text-gray-400 font-medium mt-2">Perbarui parameter komersial dan stok fisik untuk figur: <span class="text-gray-900 font-semibold">{{ $product->name }}</span></p>
    </div>

    <div class="bg-white rounded-3xl border border-gray-50 p-6 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Nama Koleksi Figur</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required
                            class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-950 focus:border-gray-950 transition-colors">
                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="material_size" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Spesifikasi Bahan & Ukuran</label>
                        <input id="material_size" name="material_size" type="text" value="{{ old('material_size', $product->material_size) }}"
                            class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-950 focus:border-gray-950 transition-colors">
                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('material_size')" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Harga (Rupiah)</label>
                            <input id="price" name="price" type="number" min="0" value="{{ old('price', intval($product->price)) }}" required
                                class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-950 focus:border-gray-950 transition-colors">
                            <x-input-error class="mt-2 text-xs" :messages="$errors->get('price')" />
                        </div>
                        <div>
                            <label for="stock" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Kuantitas Stok</label>
                            <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}" required
                                class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-950 focus:border-gray-950 transition-colors">
                            <x-input-error class="mt-2 text-xs" :messages="$errors->get('stock')" />
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="description" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Deskripsi Detail Produk</label>
                        <textarea id="description" name="description" rows="5"
                            class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-950 focus:border-gray-950 transition-colors">{{ old('description', $product->description) }}</textarea>
                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Foto Saat Ini</label>
                        <div class="flex items-start space-x-4">
                            <div class="w-20 h-20 rounded-xl bg-gray-50 border border-gray-100 overflow-hidden flex-shrink-0">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-[10px] font-bold">NO IMG</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label for="image" class="sr-only">Pilih foto baru</label>
                                <input id="image" name="image" type="file" accept="image/png, image/jpeg, image/jpg"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:uppercase file:tracking-wider file:bg-gray-50 file:text-gray-950 hover:file:bg-gray-100 border border-gray-200 rounded-xl p-1 focus:outline-none">
                                <p class="text-[10px] text-gray-400 mt-2">Biarkan kosong jika tidak ingin mengubah foto produk.</p>
                                <x-input-error class="mt-2 text-xs" :messages="$errors->get('image')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-50">
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-gray-400 uppercase tracking-wider hover:text-gray-900 transition-colors">Batal</a>
                <button type="submit" class="bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-6 py-3.5 rounded-xl hover:bg-black transition-colors shadow-sm">
                    Perbarui Inventaris
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>