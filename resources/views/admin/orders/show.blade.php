<x-admin-layout>
    <x-slot name="title">Detail Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</x-slot>

    <div class="mb-8">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-xs font-semibold text-gray-400 hover:text-gray-950 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path></svg>
            Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-12 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-sm text-gray-400 font-medium mt-2">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 rounded-xl bg-gray-50 border border-gray-100 text-sm font-medium text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-3 text-gray-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl border border-gray-50 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Informasi Pelanggan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Nama Pemesan</p>
                        <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Email</p>
                        <p class="text-sm font-medium text-gray-900">{{ $order->user->email }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Alamat Pengiriman Lengkap</p>
                        <div class="bg-gray-50 rounded-xl p-4 mt-2">
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $order->shipping_address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-50 p-8 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Rincian Pembayaran</h2>
                <div class="flex items-center justify-between py-4 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Subtotal Transaksi</span>
                    <span class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between py-4">
                    <span class="text-base font-bold text-gray-900">Total Dibayar</span>
                    <span class="text-xl font-extrabold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-gray-50 rounded-3xl border border-gray-100 p-8 sticky top-8">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Pembaruan Logistik</h2>
                
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Status Pesanan</label>
                        <select id="status" name="status" class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-950 focus:border-gray-950 transition-colors bg-white">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim (Shipped)</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('status')" />
                    </div>

                    <div>
                        <label for="tracking_number" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">Nomor Resi (Opsional)</label>
                        <input id="tracking_number" name="tracking_number" type="text" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Contoh: JX1234567890"
                            class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-950 focus:border-gray-950 transition-colors bg-white">
                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('tracking_number')" />
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-gray-950 text-white text-xs font-bold uppercase tracking-wider px-6 py-4 rounded-xl hover:bg-black transition-colors shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>