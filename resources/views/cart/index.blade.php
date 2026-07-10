<x-app-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Keranjang Belanja</h1>

            @if(session('success'))
                <div class="mt-6 p-4 rounded-xl bg-gray-50 border border-gray-100 text-sm font-medium text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-3 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-6 p-4 rounded-xl bg-red-50 border border-red-100 text-sm font-medium text-red-900 flex items-center">
                    <svg class="w-5 h-5 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="mt-16 flex flex-col items-center justify-center py-24 text-center">
                    <svg class="w-16 h-16 text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-900">Keranjang Anda kosong</h2>
                    <p class="mt-2 text-sm text-gray-500">Sepertinya Anda belum menambahkan action figure apa pun.</p>
                    <a href="{{ route('home') }}" class="mt-8 bg-gray-900 border border-transparent rounded-xl py-3 px-8 text-sm font-semibold text-white hover:bg-black transition-colors">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    
                    <section aria-labelledby="cart-heading" class="lg:col-span-7">
                        <h2 id="cart-heading" class="sr-only">Item di keranjang Anda</h2>

                        <ul role="list" class="border-t border-b border-gray-100 divide-y divide-gray-100">
                            @foreach($cartItems as $item)
                                <li class="flex py-6 sm:py-10">
                                    
                                    <div class="flex-shrink-0">
                                        @if($item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl object-cover object-center bg-gray-50">
                                        @else
                                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                        <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                            <div>
                                                <div class="flex justify-between">
                                                    <h3 class="text-sm">
                                                        <a href="{{ route('product.show', $item->product->slug) }}" class="font-medium text-gray-900 hover:text-gray-600">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="mt-1 flex text-sm">
                                                    <p class="text-gray-500">{{ $item->product->material_size ?? 'Skala standar' }}</p>
                                                </div>
                                                <p class="mt-1 text-sm font-medium text-gray-900">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                            </div>

                                            <div class="mt-4 sm:mt-0 sm:pr-9">
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-xs uppercase tracking-widest text-gray-400 font-semibold">Qty:</span>
                                                    <span class="text-sm font-medium text-gray-900">{{ $item->quantity }}</span>
                                                </div>

                                                <div class="absolute top-0 right-0 sm:relative sm:top-auto sm:right-auto sm:mt-4">
                                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="-m-2 p-2 inline-flex text-gray-400 hover:text-red-500 transition-colors">
                                                            <span class="sr-only">Hapus</span>
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-3xl px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                        <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Ringkasan Pesanan</h2>

                        <dl class="mt-6 space-y-4 text-sm text-gray-600">
                            <div class="flex items-center justify-between">
                                <dt>Subtotal</dt>
                                <dd class="font-medium text-gray-900">Rp {{ number_format($totalPrice, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex items-center text-sm">
                                    <span>Estimasi Ongkos Kirim</span>
                                </dt>
                                <dd class="font-medium text-gray-900">Dihitung saat checkout</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">Total Akhir</dt>
                                <dd class="text-base font-medium text-gray-900">Rp {{ number_format($totalPrice, 0, ',', '.') }}</dd>
                            </div>
                        </dl>

                        <div class="mt-8">
                            <a href="{{ route('checkout.index') }}" class="w-full bg-gray-900 border border-transparent rounded-xl shadow-sm py-4 px-4 text-base font-semibold text-white hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 focus:ring-offset-gray-50 flex items-center justify-center transition-all duration-200">
                                Lanjut ke Checkout
                            </a>
                        </div>
                        
                        <div class="mt-6 text-center text-xs text-gray-500">
                            <p>
                                atau 
                                <a href="{{ route('home') }}" class="text-gray-900 font-medium hover:underline">
                                    lanjutkan berbelanja<span aria-hidden="true"> &rarr;</span>
                                </a>
                            </p>
                        </div>
                    </section>
                    
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>