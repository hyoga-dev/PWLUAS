<x-admin-layout>
    <x-slot name="title">Manajemen Produk</x-slot>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-12 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Inventaris Produk</h1>
            <p class="text-sm text-gray-400 font-medium mt-2">Kelola katalog, pantau ketersediaan stok, dan perbarui harga action figure.</p>
        </div>
        <div>
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-5 py-3.5 rounded-xl hover:bg-black transition-colors shadow-sm">
                Tambah Produk
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 rounded-xl bg-gray-50 border border-gray-100 text-sm font-medium text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-3 text-gray-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($products->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 border border-gray-50 rounded-2xl bg-gray-50/20 text-center">
            <p class="text-sm font-medium text-gray-400">Belum ada koleksi produk di database inventaris.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-left whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider w-16">Gambar</th>
                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Produk</th>
                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Spesifikasi</th>
                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga</th>
                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok</th>
                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50/30 transition-colors group">
                            <td class="py-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 overflow-hidden flex-shrink-0">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-[10px] font-bold">NO IMG</div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 font-semibold text-gray-900 text-sm">
                                {{ $product->name }}
                            </td>
                            <td class="py-4 text-gray-500 text-sm">
                                {{ $product->material_size ?? '-' }}
                            </td>
                            <td class="py-4 text-gray-900 text-sm font-medium">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 text-sm">
                                <span class="font-bold {{ $product->stock < 5 ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="py-4 text-right text-xs font-semibold tracking-wide space-x-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-gray-400 hover:text-gray-950 transition-colors">Edit</a>
                                
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-600 transition-colors font-semibold">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @endif
</x-admin-layout>