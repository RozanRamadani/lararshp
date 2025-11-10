<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RSHP UNAIR') }} - Rumah Sakit Hewan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background with clean veterinary theme -->
        <div class="min-h-screen bg-gradient-to-br from-teal-50 to-blue-50 relative">
            <!-- Main Content -->
            <div class="relative min-h-screen flex flex-col sm:justify-center items-center px-4 py-12">
                <!-- Logo and Branding -->
                <div class="text-center mb-8">
                    <a href="/" class="inline-block">
                        <div class="flex items-center justify-center mb-4">
                            <img src="/assets/images/RSHP.png"
                                 alt="RSHP UNAIR Logo"
                                 class="w-16 h-16 mr-3">
                            <div class="text-left">
                                <h1 class="text-2xl font-bold text-gray-900">RSHP UNAIR</h1>
                                <p class="text-sm text-teal-600 font-medium">Rumah Sakit Hewan</p>
                            </div>
                        </div>
                    </a>
                    <p class="text-gray-600 max-w-md mx-auto">
                        Sistem Administrasi Rumah Sakit Hewan Universitas Airlangga
                    </p>
                </div>

                <!-- Form Container -->
                <div class="w-full sm:max-w-md">
                    <div class="bg-white shadow-xl rounded-xl border border-gray-200 overflow-hidden">
                        <div class="px-8 py-8">
                            {{ $slot }}
                        </div>

                        <!-- Footer -->
                        <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                            <p class="text-xs text-center text-gray-500">
                                © 2025 RSHP UNAIR. Professional Veterinary Care.
                            </p>
                        </div>
                    </div>

                    <!-- Back to Homepage -->
                    <div class="mt-6 text-center">
                        <a href="/" class="inline-flex items-center text-teal-600 hover:text-teal-700 text-sm font-medium transition duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>

                <!-- Features/Trust indicators -->
                <div class="mt-12 text-center">
                    <div class="flex justify-center space-x-8 text-xs text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Data Aman
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            SSL Secured
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-teal-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            24/7 Support
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
