<x-layout>
    <x-slot:title>{{ $title ?? 'Layanan - RSHP Universitas Airlangga' }}</x-slot:title>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-teal-50 to-blue-50 overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23059669" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        <div class="relative container mx-auto px-6 lg:px-12 py-16 lg:py-24">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Layanan <span class="text-teal-600">Terpadu</span><br>
                    untuk Kesehatan Hewan
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Rumah Sakit Hewan Universitas Airlangga menyediakan pelayanan kesehatan komprehensif 
                    dengan standar medis tinggi dan teknologi modern untuk kesejahteraan hewan kesayangan Anda.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#layanan-utama" class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Jelajahi Layanan
                    </a>
                    <a href="#konsultasi" class="border-2 border-teal-600 text-teal-600 hover:bg-teal-600 hover:text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300">
                        Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">24/7</div>
                    <div class="text-gray-600 text-sm">Layanan Darurat</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">15+</div>
                    <div class="text-gray-600 text-sm">Dokter Hewan</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">5000+</div>
                    <div class="text-gray-600 text-sm">Hewan Dirawat</div>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900">50+</div>
                    <div class="text-gray-600 text-sm">Tahun Pengalaman</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Services -->
    <section id="layanan-utama" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Layanan Utama Kami</h2>
                <div class="w-24 h-1 bg-teal-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Dengan tim dokter hewan berpengalaman dan fasilitas modern, kami memberikan perawatan terbaik untuk hewan kesayangan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <!-- Emergency Care -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                    <div class="relative h-64 bg-red-600 bg-cover bg-center" style="background-image: url('/assets/images/emergency.jpg');">
                        <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/60"></div>
                        <div class="absolute top-6 left-6">
                            <div class="w-12 h-12 bg-red-500 bg-opacity-80 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-2xl font-bold mb-2 drop-shadow-lg">Gawat Darurat</h3>
                            <p class="text-white drop-shadow">Pelayanan 24 jam untuk kondisi kritis</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Trauma dan kecelakaan
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Keracunan akut
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Sesak napas dan kolaps
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Persalinan sulit
                            </li>
                        </ul>
                        <div class="mt-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Hotline: (031) 5914042
                            </span>
                        </div>
                    </div>
                </div>

                <!-- General Health -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                    <div class="relative h-64 bg-teal-600 bg-cover bg-center" style="background-image: url('/assets/images/checkup.jpg');">
                        <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/60"></div>
                        <div class="absolute top-6 left-6">
                            <div class="w-12 h-12 bg-teal-500 bg-opacity-80 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-2xl font-bold mb-2 drop-shadow-lg">Kesehatan Umum</h3>
                            <p class="text-white drop-shadow">Pemeriksaan rutin dan preventif</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Check-up rutin
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Vaksinasi lengkap
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Deworming dan perawatan parasit
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Konsultasi nutrisi
                            </li>
                        </ul>
                        <div class="mt-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                                Senin - Sabtu
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Surgery -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                    <div class="relative h-64 bg-blue-600 bg-cover bg-center" style="background-image: url('/assets/images/surgery.jpg');">
                        <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/60"></div>
                        <div class="absolute top-6 left-6">
                            <div class="w-12 h-12 bg-blue-500 bg-opacity-80 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <h3 class="text-2xl font-bold mb-2 drop-shadow-lg">Bedah & Operasi</h3>
                            <p class="text-white drop-shadow">Prosedur bedah dengan teknologi modern</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Sterilisasi & kastrasi
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Bedah orthopedi
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Bedah tumor & kanker
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-teal-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Bedah mata & THT
                            </li>
                        </ul>
                        <div class="mt-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Perjanjian Required
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Laboratorium</h4>
                    <p class="text-gray-600 text-sm">Tes darah, urin, feses dan analisis mikroskopis</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11h16V10"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Radiologi</h4>
                    <p class="text-gray-600 text-sm">X-ray digital dan USG untuk diagnostik</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Grooming</h4>
                    <p class="text-gray-600 text-sm">Perawatan bulu, kuku dan kebersihan hewan</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Edukasi</h4>
                    <p class="text-gray-600 text-sm">Konseling perawatan dan program edukasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Specialty Services -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Layanan Spesialis</h2>
                <div class="w-24 h-1 bg-teal-600 mx-auto mb-6"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Dengan dukungan dokter spesialis dan teknologi canggih, kami menangani kasus-kasus kompleks dengan pendekatan multidisiplin.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Kardiologi Veteriner</h3>
                            <p class="text-gray-600">Diagnosis dan terapi penyakit jantung dengan EKG dan echocardiography.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Neurologi</h3>
                            <p class="text-gray-600">Penanganan gangguan saraf pusat dan perifer dengan teknologi diagnostik modern.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Oftalmologi</h3>
                            <p class="text-gray-600">Spesialis mata dengan microsurgery untuk katarak, glaukoma dan kelainan kornea.</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Onkologi</h3>
                            <p class="text-gray-600">Terapi kanker komprehensif dengan chemotherapy dan radioterapi.</p>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl p-8 text-white">
                        <h3 class="text-2xl font-bold mb-4">Mengapa Memilih RSHP?</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-teal-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Tim dokter hewan berpengalaman 15+ tahun
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-teal-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Fasilitas bedah dan ICU modern
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-teal-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Laboratorium dan radiologi in-house
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-teal-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Tersedia ambulans untuk emergency
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-teal-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Program follow-up dan rehabilitasi
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="#konsultasi" class="bg-white text-teal-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                                Konsultasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="konsultasi" class="py-20 bg-gradient-to-r from-teal-600 to-teal-700">
        <div class="container mx-auto px-6 lg:px-12 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Siap Memberikan Perawatan Terbaik</h2>
            <p class="text-xl text-teal-100 mb-8 max-w-3xl mx-auto">
                Tim dokter hewan kami siap melayani 24 jam untuk memberikan perawatan kesehatan terbaik bagi hewan kesayangan Anda.
            </p>
            
            <div class="flex flex-col md:flex-row gap-6 justify-center items-center max-w-2xl mx-auto">
                <div class="flex-1 w-full">
                    <a href="tel:(031)5914042" class="block w-full bg-white text-teal-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Telepon Sekarang
                        </div>
                    </a>
                </div>
                
                <div class="flex-1 w-full">
                    <a href="https://wa.me/6281234569007" class="block w-full bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                        <div class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                            </svg>
                            WhatsApp Chat
                        </div>
                    </a>
                </div>
            </div>

            <p class="text-teal-100 mt-6">
                <strong>Layanan Darurat 24/7:</strong> (031) 5914042 • <strong>WhatsApp:</strong> +62 812-3456-9007
            </p>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

</x-layout>
