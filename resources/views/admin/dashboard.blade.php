<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - FigStore</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <div class="flex h-screen overflow-hidden bg-white">
        
        <aside class="w-64 bg-white border-r border-gray-100 flex-col justify-between hidden md:flex flex-shrink-0 z-20">
            <div class="p-8">
                <div class="mb-12">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-tight text-gray-900 flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-gray-950"></span>
                        <span>FigStore Admin</span>
                    </a>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-semibold text-gray-950 bg-gray-50 rounded-xl transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-950" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-400 hover:text-gray-950 hover:bg-gray-50/50 rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-950 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                        Produk
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-400 hover:text-gray-950 hover:bg-gray-50/50 rounded-xl transition-all group">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-950 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.119-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        Pesanan
                    </a>
                </nav>
            </div>

            <div class="p-8 border-t border-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-gray-950 flex items-center justify-center text-xs font-bold text-white uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-semibold text-gray-900 line-clamp-1 leading-none mb-1">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-400 font-medium tracking-wider uppercase">Administrator</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-1" title="Keluar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-white p-8 sm:p-12 lg:p-16">
            
            <div class="max-w-6xl mx-auto">
                <div class="mb-14">
                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Dashboard Overview</h1>
                    <p class="text-sm text-gray-400 font-medium mt-2">Analisis data performa penjualan dan ringkasan manajemen logistik toko.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Total Penjualan</span>
                            <h2 class="text-2xl font-bold text-gray-900 mt-4 tracking-tight">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Pesanan</span>
                            <h2 class="text-2xl font-bold text-gray-900 mt-4 tracking-tight">
                                {{ number_format($totalOrders, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Total Produk</span>
                            <h2 class="text-2xl font-bold text-gray-900 mt-4 tracking-tight">
                                {{ number_format($totalProducts ?? \App\Models\Product::count(), 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_8px_30px_rgb(0,0,0,0.015)] transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.03)] flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Total User</span>
                            <h2 class="text-2xl font-bold text-gray-900 mt-4 tracking-tight">
                                {{ number_format($totalUsers, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>

                </div>

                <div class="mt-16 border-t border-gray-100 pt-12">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Perhatian Stok Kritis</h3>
                            <p class="text-xs text-gray-400 mt-1">Daftar item action figure dengan kuantitas di bawah ambang batas aman bisnis.</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 tracking-wide">
                            {{ $lowStockCount }} Item Terancam
                        </span>
                    </div>

                    @if($lowStockProducts->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 border border-gray-50 rounded-2xl bg-gray-50/20">
                            <p class="text-xs font-medium text-gray-400">Seluruh level kuantitas produk berada pada kondisi aman.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 text-left">
                                <thead>
                                    <tr>
                                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Koleksi Figur</th>
                                        <th class="pb-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Sisa Fisik</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($lowStockProducts as $product)
                                        <tr class="hover:bg-gray-50/40 transition-colors">
                                            <td class="py-4 text-sm font-medium text-gray-900">
                                                {{ $product->name }}
                                            </td>
                                            <td class="py-4 text-sm font-bold text-red-600 text-right">
                                                {{ $product->stock }} <span class="text-[10px] font-semibold text-gray-400 uppercase ml-1">unit</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div> </main>
    </div>

</body>
</html>