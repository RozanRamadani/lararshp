<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        {{-- Administrator Menu --}}
                        @if(auth()->user()->hasRole('Administrator'))
                            <x-nav-link :href="route('admin.data.index')" :active="request()->routeIs('admin.*')">
                                {{ __('Data Management') }}
                            </x-nav-link>
                        @endif

                        {{-- Resepsionis Menu --}}
                        @if(auth()->user()->hasRole('Resepsionis'))
                            <x-nav-link :href="route('resepsionis.temu-dokter.index')" :active="request()->routeIs('resepsionis.temu-dokter.*')">
                                {{ __(' Appointments') }}
                            </x-nav-link>
                            <x-nav-link :href="route('resepsionis.pemilik.index')" :active="request()->routeIs('resepsionis.pemilik.*')">
                                {{ __('Owners') }}
                            </x-nav-link>
                            <x-nav-link :href="route('resepsionis.pet.index')" :active="request()->routeIs('resepsionis.pet.*')">
                                {{ __('Pets') }}
                            </x-nav-link>
                        @endif

                        {{-- Dokter Menu --}}
                        @if(auth()->user()->hasAnyRole(['Dokter']))
                            <x-nav-link :href="route('dokter.pasien.index')" :active="request()->routeIs('dokter.pasien.*')">
                                {{ __('Patients') }}
                            </x-nav-link>
                            <x-nav-link :href="route('dokter.rekam-medis.index')" :active="request()->routeIs('dokter.rekam-medis.*')">
                                {{ __('Medical Records') }}
                            </x-nav-link>
                        @endif

                        {{-- Perawat Menu --}}
                        @if(auth()->user()->hasAnyRole(['Perawat']))
                            <x-nav-link :href="route('perawat.pasien.index')" :active="request()->routeIs('perawat.pasien.*')">
                                {{ __('Patient Care') }}
                            </x-nav-link>
                            <x-nav-link :href="route('perawat.rekam-medis.index')" :active="request()->routeIs('perawat.rekam-medis.*')">
                                {{ __('Medical Records') }}
                            </x-nav-link>
                        @endif

                        {{-- Pemilik Menu --}}
                        @if(auth()->user()->hasRole('Pemilik'))
                            <x-nav-link :href="route('pemilik.my-pets')" :active="request()->routeIs('pemilik.my-pets*')">
                                {{ __('My Pets') }}
                            </x-nav-link>
                            <x-nav-link :href="route('pemilik.my-appointments')" :active="request()->routeIs('pemilik.my-appointments*')">
                                {{ __('My Appointments') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()?->name ?? 'Guest' }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @auth
                {{-- Administrator Menu --}}
                @if(auth()->user()->hasRole('Administrator'))
                    <x-responsive-nav-link :href="route('admin.data.index')" :active="request()->routeIs('admin.*')">
                        {{ __('Data Management') }}
                    </x-responsive-nav-link>
                @endif

                {{-- Resepsionis Menu --}}
                @if(auth()->user()->hasRole('Resepsionis'))
                    <x-responsive-nav-link :href="route('resepsionis.temu-dokter.index')" :active="request()->routeIs('resepsionis.temu-dokter.*')">
                        {{ __('📅 Appointments') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('resepsionis.pemilik.index')" :active="request()->routeIs('resepsionis.pemilik.*')">
                        {{ __('Owners') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('resepsionis.pet.index')" :active="request()->routeIs('resepsionis.pet.*')">
                        {{ __('Pets') }}
                    </x-responsive-nav-link>
                @endif

                {{-- Dokter Menu --}}
                @if(auth()->user()->hasAnyRole(['Administrator', 'Dokter']))
                    <x-responsive-nav-link :href="route('dokter.pasien.index')" :active="request()->routeIs('dokter.pasien.*')">
                        {{ __('Patients') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('dokter.rekam-medis.index')" :active="request()->routeIs('dokter.rekam-medis.*')">
                        {{ __('Medical Records') }}
                    </x-responsive-nav-link>
                @endif

                {{-- Perawat Menu --}}
                @if(auth()->user()->hasAnyRole(['Administrator', 'Perawat']))
                    <x-responsive-nav-link :href="route('perawat.pasien.index')" :active="request()->routeIs('perawat.pasien.*')">
                        {{ __('Patient Care') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('perawat.rekam-medis.index')" :active="request()->routeIs('perawat.rekam-medis.*')">
                        {{ __('Medical Records') }}
                    </x-responsive-nav-link>
                @endif

                {{-- Pemilik Menu --}}
                @if(auth()->user()->hasRole('Pemilik'))
                    <x-responsive-nav-link :href="route('pemilik.my-pets')" :active="request()->routeIs('pemilik.my-pets*')">
                        {{ __('My Pets') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pemilik.my-appointments')" :active="request()->routeIs('pemilik.my-appointments*')">
                        {{ __('My Appointments') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()?->name ?? 'Guest' }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()?->email ?? 'guest@example.com' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
