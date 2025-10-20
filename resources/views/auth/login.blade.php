<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Sistem</h2>
        <p class="text-gray-600 text-sm">Silakan masukkan kredensial Anda untuk mengakses dashboard admin RSHP</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
                Alamat Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 bg-gray-50 hover:bg-white"
                placeholder="admin@rshp.unair.ac.id">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Kata Sandi
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 bg-gray-50 hover:bg-white"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 focus:ring-2">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                    class="text-sm text-teal-600 hover:text-teal-800 font-medium transition duration-200">
                    Lupa password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button type="submit" 
            class="w-full bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200 ease-in-out">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Masuk ke Dashboard
        </button>

        <!-- Register Link -->
        <div class="text-center mt-6 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-medium text-teal-600 hover:text-teal-800 transition duration-200">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
