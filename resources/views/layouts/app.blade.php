<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FigStore') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Memastikan tipografi bawaan menggunakan font Inter */
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    
    <body class="font-sans antialiased text-gray-900 bg-white flex flex-col min-h-screen">
        
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white border-b border-gray-50">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-12">
                    
                    <div class="flex flex-col">
                        <a href="{{ route('home') }}" class="text-xl font-extrabold tracking-tight text-gray-900 flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-gray-950"></span>
                            <span>FigStore</span>
                        </a>
                        <p class="mt-4 text-sm text-gray-400 font-medium leading-relaxed max-w-xs">
                            Toko spesialis figur koleksi original.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-5">Tautan Cepat</h3>
                        <ul class="space-y-3.5">
                            {{-- <li>
                                <a href="{{ route('home') }}" class="text-sm text-gray-500 font-medium hover:text-gray-900 transition-colors duration-200">Beranda</a>
                            </li> --}}
                            <li>
                                <a href="{{ route('home') }}" class="text-sm text-gray-500 font-medium hover:text-gray-900 transition-colors duration-200">Katalog</a>
                            </li>
                            @auth
                                <li>
                                    <a href="{{ route('orders.index') }}" class="text-sm text-gray-500 font-medium hover:text-gray-900 transition-colors duration-200">Pesanan Saya</a>
                                </li>
                            @endauth
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-5">Bantuan & Legal</h3>
                        <ul class="space-y-3.5">
                            <li>
                                <a href="#" class="text-sm text-gray-500 font-medium hover:text-gray-900 transition-colors duration-200">Hubungi Kami</a>
                            </li>
                            <li>
                                <a href="#" class="text-sm text-gray-500 font-medium hover:text-gray-900 transition-colors duration-200">Syarat & Ketentuan</a>
                            </li>
                            <li>
                                <a href="#" class="text-sm text-gray-500 font-medium hover:text-gray-900 transition-colors duration-200">Kebijakan Privasi</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-16 pt-8 border-t border-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-xs text-gray-400 font-medium tracking-wide text-center md:text-left">
                        &copy; {{ date('Y') }} FigStore. Hak cipta dilindungi undang-undang.
                    </p>
                    <div class="flex space-x-5 text-gray-400">
                        <a href="#" class="hover:text-gray-900 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="hover:text-gray-900 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.46 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </footer>

    </body>
</html>