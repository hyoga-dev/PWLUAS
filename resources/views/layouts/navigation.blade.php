<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tighter text-gray-900 hover:opacity-80 transition-opacity">
                        FIG<span class="text-gray-300">STORE</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-12 sm:flex h-full">
                    <a href="{{ route('home') }}" class="inline-flex items-center pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-400 hover:text-gray-900 hover:border-gray-200' }} text-sm font-semibold tracking-wide transition-all duration-200 h-full">
                        Katalog
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-6">
                
                @auth
                    <a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-gray-900 transition-colors relative p-2">
                        <span class="sr-only">Keranjang Belanja</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-xl text-gray-500 bg-white hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Pengaturan
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-sm font-medium text-red-600 hover:bg-red-50">
                                    Keluar
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="bg-gray-900 border border-transparent rounded-xl py-2.5 px-5 text-sm font-semibold text-white hover:bg-black transition-colors duration-200">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>