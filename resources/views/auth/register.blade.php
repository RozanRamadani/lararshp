<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Daftar Akun</h2>
        <p class="text-gray-600 text-sm">Buat akun baru untuk mengakses sistem administrasi RSHP</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Nama Lengkap
            </label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 bg-gray-50 hover:bg-white"
                placeholder="Dr. John Smith">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
                Alamat Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 bg-gray-50 hover:bg-white"
                placeholder="dokter@rshp.unair.ac.id">
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
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 bg-gray-50 hover:bg-white"
                placeholder="Minimal 8 karakter">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-1 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Konfirmasi Kata Sandi
            </label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 bg-gray-50 hover:bg-white"
                placeholder="Ulangi kata sandi">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start">
            <input id="terms" type="checkbox" required
                class="w-4 h-4 mt-1 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 focus:ring-2">
            <label for="terms" class="ml-2 text-sm text-gray-600">
                Saya menyetujui <a href="#" class="text-teal-600 hover:text-teal-800 font-medium">syarat dan ketentuan</a> 
                serta <a href="#" class="text-teal-600 hover:text-teal-800 font-medium">kebijakan privasi</a> RSHP UNAIR.
            </label>
        </div>

        <!-- Register Button -->
        <button type="submit" 
            class="w-full bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200 ease-in-out">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Daftar Akun
        </button>

        <!-- Login Link -->
        <div class="text-center mt-6 pt-4 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-medium text-teal-600 hover:text-teal-800 transition duration-200">
                    Masuk sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
