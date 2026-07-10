<x-app-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-12">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Checkout</h1>
                <p class="mt-2 text-sm text-gray-500 font-medium">Lengkapi detail pengiriman untuk menyelesaikan pesanan Anda.</p>
            </div>

            @if(session('error'))
                <div class="mb-8 p-4 rounded-xl bg-red-50 border border-red-100 text-sm font-medium text-red-900 flex items-center">
                    <svg class="w-5 h-5 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 xl:gap-x-16">
                
                <div class="lg:col-span-7">
                    <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        
                        <div class="border-b border-gray-100 pb-10">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pengiriman</h2>

                            <div class="grid grid-cols-1 gap-y-6">
                                <div>
                                    <label for="shipping_address" class="block text-xs uppercase tracking-widest font-semibold text-gray-400 mb-2">
                                        Alamat Lengkap (Jalan, RT/RW, Kecamatan, Kota, Kode Pos)
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="shipping_address" name="shipping_address" rows="5" required
                                            placeholder="Tuliskan alamat pengiriman dengan sangat detail..."
                                            class="block w-full rounded-xl border-gray-200 py-3 px-4 text-gray-900 text-sm focus:ring-gray-900 focus:border-gray-900 transition-colors placeholder-gray-300 shadow-sm">{{ old('shipping_address') }}</textarea>
                                    </div>
                                    <x-input-error :messages="$errors->get('shipping_address')" class="mt-2 text-xs" />
                                </div>
                                
                                </div>
                        </div>
                    </form>
                </div>

                <div class="mt-10 lg:mt-0 lg:col-span-5">
                    <div class="bg-gray-50 rounded-3xl border border-gray-100 px-6 py-8 sm:p-8 sticky top-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Ringkasan Pesanan</h2>

                        <ul role="list" class="divide-y divide-gray-200 border-b border-gray-200 pb-6 mb-6">
                            @foreach($cartItems as $item)
                                <li class="flex py-4 space-x-4">
                                    <div class="flex-shrink-0 w-16 h-16 rounded-xl bg-white border border-gray-100 overflow-hidden">
                                        @if($item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-center object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 flex flex-col justify-center">
                                        <h3 class="text-sm font-medium text-gray-900 line-clamp-1">{{ $item->product->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="flex flex-col justify-center text-right">
                                        <p class="text-sm font-medium text-gray-900">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <dl class="space-y-4 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-gray-900">Rp {{ number_format($totalPrice, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Ongkos Kirim (Flat)</dt>
                                <dd class="font-medium text-gray-900">Rp 0</dd>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-4 mt-4">
                                <dt class="text-base font-semibold text-gray-900">Total Pembayaran</dt>
                                <dd class="text-base font-semibold text-gray-900">Rp {{ number_format($totalPrice, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <button type="submit" form="checkout-form" class="w-full bg-gray-900 border border-transparent rounded-xl shadow-[0_4px_14px_0_rgb(0,0,0,0.1)] py-4 px-4 text-sm font-bold text-white uppercase tracking-wider hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200">
                                Konfirmasi & Buat Pesanan
                            </button>
                        </div>
                        
                        <div class="mt-6 flex items-center justify-center space-x-2 text-xs text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span>Transaksi Anda aman dan terenkripsi</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>