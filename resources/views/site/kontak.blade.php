<x-layout>
    <x-slot:title>{{ $title ?? 'Layanan - RSHP Universitas Airlangga' }}</x-slot:title>
    
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <section class="relative bg-teal-600 text-white py-20">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Hubungi Kami</h1>
                <p class="text-xl md:text-2xl text-teal-100 max-w-3xl mx-auto">
                    Kami siap membantu kesehatan hewan peliharaan Anda. Jangan ragu untuk menghubungi tim profesional kami.
                </p>
            </div>
        </section>

        <!-- Contact Information Cards -->
        <section class="py-16 -mt-8 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Phone -->
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Telepon</h3>
                        <p class="text-gray-600 mb-2">Hubungi kami langsung</p>
                        <a href="tel:(031)5992785" class="text-teal-600 font-medium hover:text-teal-700">(031) 5992785</a>
                    </div>

                    <!-- Email -->
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-600 mb-2">Kirim pesan elektronik</p>
                        <a href="mailto:rshp@unair.ac.id" class="text-teal-600 font-medium hover:text-teal-700">rshp@unair.ac.id</a>
                    </div>

                    <!-- Location -->
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Lokasi</h3>
                        <p class="text-gray-600 mb-2">Kunjungi langsung</p>
                        <p class="text-teal-600 font-medium">Kampus C UNAIR<br>Mulyorejo, Surabaya</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Form & Map Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div>
                        <div class="bg-gray-50 rounded-xl p-8">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                            <p class="text-gray-600 mb-8">Punya pertanyaan tentang layanan kami? Silakan isi form di bawah ini dan kami akan segera menghubungi Anda kembali.</p>
                            
                            <form class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" id="nama" name="nama" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                    </div>
                                    <div>
                                        <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                        <input type="tel" id="telepon" name="telepon" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                </div>

                                <div>
                                    <label for="hewan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Hewan Peliharaan</label>
                                    <select id="hewan" name="hewan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                        <option value="">Pilih jenis hewan</option>
                                        <option value="kucing">Kucing</option>
                                        <option value="anjing">Anjing</option>
                                        <option value="kelinci">Kelinci</option>
                                        <option value="hamster">Hamster</option>
                                        <option value="burung">Burung</option>
                                        <option value="reptil">Reptil</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="layanan" class="block text-sm font-medium text-gray-700 mb-2">Layanan yang Dibutuhkan</label>
                                    <select id="layanan" name="layanan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors">
                                        <option value="">Pilih layanan</option>
                                        <option value="konsultasi">Konsultasi Umum</option>
                                        <option value="emergency">Gawat Darurat</option>
                                        <option value="vaksinasi">Vaksinasi</option>
                                        <option value="operasi">Operasi</option>
                                        <option value="perawatan">Perawatan Khusus</option>
                                        <option value="checkup">Medical Check-up</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="pesan" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                                    <textarea id="pesan" name="pesan" rows="4" placeholder="Ceritakan kondisi hewan peliharaan Anda atau pertanyaan lainnya..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors resize-none"></textarea>
                                </div>

                                <button type="submit" class="w-full bg-teal-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors">
                                    Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Map & Additional Info -->
                    <div class="space-y-8">
                        <!-- Map Placeholder -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Lokasi Kami</h3>
                            <div class="bg-gray-200 rounded-xl h-64 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-gray-600">Peta Interaktif</p>
                                    <p class="text-sm text-gray-500">Google Maps akan dimuat di sini</p>
                                </div>
                            </div>
                        </div>

                        <!-- Operating Hours -->
                        <div class="bg-teal-50 rounded-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Jam Operasional</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Senin - Jumat</span>
                                    <span class="font-semibold text-gray-900">08:00 - 16:00 WIB</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Sabtu</span>
                                    <span class="font-semibold text-gray-900">08:00 - 14:00 WIB</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Minggu</span>
                                    <span class="font-semibold text-red-600">Tutup</span>
                                </div>
                                <hr class="my-4">
                                <div class="bg-red-100 border border-red-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <span class="text-sm font-semibold text-red-700">Layanan Emergency 24 Jam</span>
                                    </div>
                                    <p class="text-sm text-red-600 mt-1">Untuk kasus gawat darurat, hubungi (031) 5992785</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Contact -->
                        <div class="bg-white border-2 border-teal-200 rounded-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Kontak Cepat</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">(031) 5992785</p>
                                        <p class="text-sm text-gray-600">Telepon langsung</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center mr-4">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.108"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">WhatsApp</p>
                                        <p class="text-sm text-gray-600">Chat langsung via WA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan yang Sering Diajukan</h2>
                    <p class="text-xl text-gray-600">Temukan jawaban untuk pertanyaan umum seputar layanan kami</p>
                </div>

                <div class="space-y-6">
                    <!-- FAQ Item 1 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 bg-teal-50 border-l-4 border-teal-500">
                            <h3 class="text-lg font-semibold text-gray-900">Apakah perlu membuat janji temu sebelum berkunjung?</h3>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-gray-600">Untuk layanan rutin seperti konsultasi dan vaksinasi, kami sangat menyarankan untuk membuat janji temu terlebih dahulu. Namun, untuk kasus emergency, Anda dapat langsung datang kapan saja.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 bg-teal-50 border-l-4 border-teal-500">
                            <h3 class="text-lg font-semibold text-gray-900">Apa saja dokumen yang perlu dibawa saat berkunjung?</h3>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-gray-600">Bawa kartu identitas pemilik, buku kesehatan hewan (jika ada), dan riwayat vaksinasi atau pengobatan sebelumnya. Untuk kunjungan pertama, kami akan membuatkan kartu kesehatan baru untuk hewan peliharaan Anda.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 py-4 bg-teal-50 border-l-4 border-teal-500">
                            <h3 class="text-lg font-semibold text-gray-900">Apakah tersedia layanan emergency 24 jam?</h3>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-gray-600">Ya, kami menyediakan layanan emergency 24 jam untuk kasus-kasus gawat darurat. Silakan hubungi nomor telepon kami (031) 5992785 untuk koordinasi sebelum datang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-footer />
</x-layout>
