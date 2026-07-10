<x-app-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <nav class="mb-10 text-sm text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors duration-200">Katalog</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 font-medium">{{ $product->name }}</span>
            </nav>

            <div class="lg:grid lg:grid-cols-2 lg:gap-x-16 lg:items-start">
                
                <div class="w-full rounded-2xl overflow-hidden bg-gray-50 aspect-w-1 aspect-h-1 flex justify-center items-center">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="object-cover object-center w-full h-full">
                    @else
                        <div class="text-gray-300 flex flex-col items-center justify-center py-32">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium tracking-wide">NO IMAGE</span>
                        </div>
                    @endif
                </div>

                <div class="mt-10 px-4 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                    
                    <div class="mt-4">
                        <p class="text-4xl text-gray-900 font-medium tracking-tight">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    @if($product->material_size)
                    <div class="mt-8">
                        <h3 class="text-xs uppercase tracking-widest font-semibold text-gray-400">Spesifikasi</h3>
                        <div class="mt-2 flex items-center text-sm text-gray-700 font-medium">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ $product->material_size }}
                        </div>
                    </div>
                    @endif

                    <div class="mt-8 border-t border-gray-100 pt-8">
                        <h3 class="text-xs uppercase tracking-widest font-semibold text-gray-400">Deskripsi</h3>
                        <div class="mt-4 text-sm text-gray-500 leading-loose">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>

                    <form action="{{ route('cart.store', $product->id) }}" method="POST" class="mt-10">
                        @csrf
                        <div class="flex items-center space-x-4">
                            
                            <div class="w-24">
                                <label for="quantity" class="sr-only">Kuantitas</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full rounded-xl border-gray-200 py-4 px-4 text-center text-gray-900 focus:ring-gray-900 focus:border-gray-900 text-sm font-medium transition-colors">
                            </div>
                            
                            <button type="submit" {{ $product->stock > 0 ? '' : 'disabled' }} class="flex-1 bg-gray-900 border border-transparent rounded-xl py-4 px-8 flex items-center justify-center text-sm font-semibold text-white hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed transition-all duration-200">
                                {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                            </button>
                        </div>
                        
                        <div class="mt-5 flex items-center">
                            @if($product->stock > 0)
                                <div class="w-2 h-2 rounded-full bg-gray-900 mr-2"></div>
                                <span class="text-xs text-gray-500 font-medium">In stock ({{ $product->stock }} tersedia)</span>
                            @else
                                <div class="w-2 h-2 rounded-full bg-gray-300 mr-2"></div>
                                <span class="text-xs text-gray-400 font-medium">Stok habis</span>
                            @endif
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>