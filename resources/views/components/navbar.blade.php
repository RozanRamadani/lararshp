<nav class="bg-gradient-to-r from-teal-600 to-teal-700 shadow-lg" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <a href="/" class="flex items-center">
                        <img class="size-8 hover:scale-110 transition duration-200 ease-in-out"
                            src="/assets/images/RSHP.png"
                            alt="RSHP UNAIR" />
                        <span class="ml-2 text-white font-semibold text-lg hidden sm:block">RSHP</span>
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-1">
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        <x-nav-link href="/layanan" :active="request()->is('layanan')">Layanan</x-nav-link>
                        <x-nav-link href="/kontak" :active="request()->is('kontak')">Kontak</x-nav-link>
                        <x-nav-link href="/struktur" :active="request()->is('struktur')">Struktur Organisasi</x-nav-link>
                        
                        @auth
                            <!-- Admin Dropdown -->
                            <div class="relative" x-data="{ adminOpen: false }">
                                <button @click="adminOpen = !adminOpen" 
                                    class="px-3 py-2 rounded-md text-sm font-medium text-teal-100 hover:text-white hover:bg-teal-500 focus:outline-none focus:text-white focus:bg-teal-500 transition duration-200 ease-in-out flex items-center">
                                    Admin
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <div x-show="adminOpen" @click.away="adminOpen = false" 
                                    x-transition:enter="transition ease-out duration-200" 
                                    x-transition:enter-start="transform opacity-0 scale-95" 
                                    x-transition:enter-end="transform opacity-100 scale-100" 
                                    x-transition:leave="transition ease-in duration-75" 
                                    x-transition:leave-start="transform opacity-100 scale-100" 
                                    x-transition:leave-end="transform opacity-0 scale-95" 
                                    class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5" 
                                    style="display: none;">
                                    <div class="py-1">
                                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                        <a href="{{ route('admin.jenis-hewan.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Data Jenis Hewan</a>
                                        <a href="{{ route('admin.pemilik.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Data Pemilik</a>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    @auth
                        <button type="button"
                            class="relative rounded-full bg-teal-600 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-teal-600 focus:outline-hidden">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">View notifications</span>
                            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button" @click="isOpen = !isOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-teal-600 text-sm focus:outline-hidden focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-teal-600"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <div class="size-8 rounded-full bg-teal-700 flex items-center justify-center text-white font-semibold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </button>
                            </div>

                            <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-600">{{ Auth::user()->email }}</div>
                                </div>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Guest Login/Register buttons -->
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('login') }}" class="text-teal-100 hover:text-white hover:bg-teal-500 px-3 py-2 rounded-md text-sm font-medium transition duration-200 ease-in-out">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-teal-500 hover:bg-teal-400 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 ease-in-out">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="isOpen = !isOpen"
                    class="relative inline-flex items-center justify-center rounded-md bg-teal-700 p-2 text-teal-100 hover:bg-teal-800 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-teal-700 focus:outline-none transition duration-200 ease-in-out"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <x-nav-link href="/" :active="request()->is('/')" class="block text-base font-medium">Home</x-nav-link>
            <x-nav-link href="/layanan" :active="request()->is('layanan')" class="block text-base font-medium">Layanan</x-nav-link>
            <x-nav-link href="/kontak" :active="request()->is('kontak')" class="block text-base font-medium">Kontak</x-nav-link>
            <x-nav-link href="/struktur" :active="request()->is('struktur')" class="block text-base font-medium">Struktur Organisasi</x-nav-link>
            
            @auth
                <!-- Admin Mobile Menu -->
                <div class="border-t border-teal-500 pt-2 mt-2">
                    <div class="px-3 py-2 text-sm font-medium text-teal-100">Menu Admin:</div>
                    <a href="{{ route('admin.jenis-hewan.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-teal-500 hover:text-white">Data Jenis Hewan</a>
                    <a href="{{ route('admin.pemilik.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-teal-500 hover:text-white">Data Pemilik</a>
                </div>
            @endauth
        </div>
                @auth
            <div class="border-t border-gray-700 pt-4 pb-3">
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <div class="size-10 rounded-full bg-teal-700 flex items-center justify-center text-white font-semibold text-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base/5 font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                    <button type="button"
                        class="relative ml-auto shrink-0 rounded-full bg-teal-600 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-teal-600 focus:outline-hidden">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View notifications</span>
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </button>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('dashboard') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-teal-500 hover:text-white">
                        Dashboard</a>
                    <a href="{{ route('profile.edit') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-teal-500 hover:text-white">
                        Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-teal-500 hover:text-white">
                            Sign out</button>
                    </form>
                </div>
            </div>
        @else
            <div class="border-t border-teal-500 pt-4 pb-3">
                <div class="space-y-2 px-2">
                    <a href="{{ route('login') }}"
                        class="block rounded-lg px-3 py-2 text-base font-medium text-teal-100 hover:bg-teal-500 hover:text-white transition duration-200 ease-in-out">
                        Login</a>
                    <a href="{{ route('register') }}"
                        class="block rounded-lg px-3 py-2 text-base font-semibold bg-teal-500 text-white hover:bg-teal-400 hover:shadow-md transition duration-200 ease-in-out">
                        Register</a>
                </div>
            </div>
        @endauth
    </div>
</nav>
