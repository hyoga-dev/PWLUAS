<x-admin-layout>
    <x-slot name="title">Manajemen Pesanan</x-slot>

    <div class="mb-12">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Pesanan Masuk</h1>
        <p class="text-sm text-gray-400 font-medium mt-2">Pantau transaksi pelanggan, perbarui status logistik, dan input nomor resi pengiriman.</p>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 rounded-xl bg-gray-50 border border-gray-100 text-sm font-medium text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-3 text-gray-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 border border-gray-50 rounded-2xl bg-gray-50/20 text-center">
            <p class="text-sm font-medium text-gray-400">Belum ada transaksi pesanan yang masuk.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-2xl border border-gray-50 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
            <table class="min-w-full divide-y divide-gray-100 text-left whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="py-5 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">ID Order</th>
                        <th class="py-5 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="py-5 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Harga</th>
                        <th class="py-5 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="py-5 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="py-5 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="py-4 px-6 text-sm font-bold text-gray-900">
                                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-semibold text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                            </td>
                            <td class="py-4 px-6 text-sm font-medium text-gray-900">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-gray-100 text-gray-600',
                                        'paid' => 'bg-blue-50 text-blue-600',
                                        'shipped' => 'bg-purple-50 text-purple-600',
                                        'completed' => 'bg-green-50 text-green-600',
                                        'cancelled' => 'bg-red-50 text-red-600',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Pembayaran',
                                        'paid' => 'Sudah Dibayar',
                                        'shipped' => 'Dikirim',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 text-right text-xs font-semibold tracking-wide">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-gray-400 hover:text-gray-950 transition-colors">Kelola</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</x-admin-layout>