<x-app-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-14">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Pesanan Saya</h1>
                <p class="text-sm text-gray-400 font-medium mt-2">Pantau status transaksi aktif dan lihat kembali riwayat seluruh koleksi figur yang telah Anda beli.</p>
            </div>

            @if($orders->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center border border-gray-50 rounded-3xl bg-gray-50/30 px-6">
                    <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center border border-gray-100 text-gray-300 mb-6 shadow-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.119-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">Belum Ada Pesanan</h2>
                    <p class="mt-2 text-sm text-gray-400 font-medium max-w-xs mx-auto leading-relaxed">
                        Sepertinya Anda belum pernah melakukan transaksi pembelian action figure apa pun di toko kami.
                    </p>
                    <a href="{{ route('home') }}" class="mt-8 bg-gray-900 border border-transparent rounded-xl py-3.5 px-8 text-sm font-semibold text-white hover:bg-black transition-all duration-200 shadow-sm">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                            
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-50 pb-5 gap-4">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Nomor Pesanan</span>
                                        <p class="text-base font-extrabold text-gray-900 mt-0.5">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <div class="border-l border-gray-200 h-8 hidden sm:block"></div>
                                    <div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Tanggal</span>
                                        <p class="text-sm font-semibold text-gray-600 mt-0.5">{{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    @php
                                        $statusColors = [
                                            'pending'   => 'bg-gray-50 text-gray-500 border border-gray-100',
                                            'paid'      => 'bg-blue-50/60 text-blue-600 border border-blue-50',
                                            'shipped'   => 'bg-purple-50/60 text-purple-600 border border-purple-50',
                                            'completed' => 'bg-green-50/60 text-green-600 border border-green-50',
                                            'cancelled' => 'bg-red-50/60 text-red-600 border border-red-50',
                                        ];
                                        $statusLabels = [
                                            'pending'   => 'Menunggu Pembayaran',
                                            'paid'      => 'Diproses',
                                            'shipped'   => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColors[$order->status] ?? 'bg-gray-50 text-gray-500' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="pt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Pembayaran</span>
                                    <p class="text-lg font-extrabold text-gray-900 mt-0.5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>

                                @if($order->tracking_number)
                                    <div class="bg-gray-50/60 rounded-xl px-4 py-2.5 border border-gray-50 self-start sm:self-auto">
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block">No. Resi Pengiriman</span>
                                        <span class="text-xs font-bold text-gray-900 tracking-wide mt-0.5 block">{{ $order->tracking_number }}</span>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>