<x-app-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">Koleksi Figur</h1>
            <p class="mt-4 max-w-xl mx-auto text-sm text-gray-500 font-medium">
                Eksplorasi jajaran action figure premium kami. Detail presisi untuk para kolektor sejati.
            </p>
        </div>
    </div>

    <div class="bg-white pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 border border-gray-50 rounded-3xl bg-gray-50/50">
                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-sm text-gray-500 font-medium">Belum ada koleksi figur saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-16 gap-x-8">
                    
                    @foreach($products as $product)
                        <div class="group relative flex flex-col">
                            
                            <div class="w-full aspect-w-1 aspect-h-1 bg-gray-50 rounded-2xl overflow-hidden transition-all duration-300 group-hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)]">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-700 ease-out">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <span class="text-xs font-medium tracking-wide">NO IMAGE</span>
                                    </div>
                                @endif
                                
                                @if($product->stock <= 0)
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/90 text-gray-900 backdrop-blur-sm shadow-sm">
                                            Out of Stock
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 flex flex-col flex-1">
                                <h3 class="text-sm font-semibold text-gray-900 leading-tight">
                                    <a href="{{ route('product.show', $product->slug) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                
                                <p class="mt-1 text-xs text-gray-500 line-clamp-1">
                                    {{ $product->material_size ?? 'Skala standar' }}
                                </p>
                                
                                <div class="mt-auto pt-3">
                                    <p class="text-base font-medium text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                    
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>