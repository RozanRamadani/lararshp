<x-layout>
    <x-slot:title>{{ $title ?? 'RSHP - Rumah Sakit Hewan' }}</x-slot:title>

    <!-- Hero -->
    <section class="relative bg-gray-50">
    <div class="h-96 sm:h-[520px] bg-cover bg-center" style="background-image: url('{{ asset('assets/images/cat.jpg') }}');">
            <div class="backdrop-brightness-75 h-full w-full flex items-center">
                <div class="container mx-auto px-6 lg:px-12">
                    <div class="max-w-2xl text-white">
                        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight drop-shadow">RSHP</h1>
                        <p class="mt-2 text-xl sm:text-2xl font-semibold drop-shadow">Rumah Sakit Hewan Universitas Airlangga</p>
                        <p class="mt-4 text-base sm:text-lg text-white/90">Pelayanan kesehatan hewan terpadu — klinis, gawat darurat, dan edukasi.</p>

                        <div class="mt-6 flex gap-3">
                            <a href="#appointment" class="inline-block bg-teal-400 hover:bg-teal-500 text-white px-5 py-3 rounded shadow">Buat Janji</a>
                            <a href="#services" class="inline-block bg-white/20 hover:bg-white/30 text-white px-5 py-3 rounded">Lihat Layanan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About / Intro -->
    <section class="container mx-auto px-6 lg:px-12 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold">About</h2>
                <div class="w-20 h-0.5 bg-teal-300 mt-3 mb-6"></div>
                <p class="text-gray-700 leading-relaxed">Rumah Sakit Hewan dibentuk di Fakultas Kedokteran Hewan Universitas Airlangga secara resmi berdiri pada tanggal 1 Januari 1972 berdasarkan SK Menteri Pendidikan dan Kebudayaan Republik Indonesia. Saat itu masih berupa klinik hewan yang menjadi bagian dari Departemen Klinik Veteriner, dimana klinik hewan ini juga menjadi wahana belajar mahasiswa Fakultas Kedokteran Hewan baik program S1 Kedokteran Hewan maupun Program Profesi Dokter Hewan atau lebih dikenal sebagai program Ko-Asistensi.</p>

                <a href="#about-more" class="inline-block mt-6 bg-teal-400 text-white px-5 py-3 rounded shadow">Pelajari Lebih Lanjut</a>
            </div>

            <div class="bg-white border rounded-lg p-6 shadow">
                <h3 class="text-lg font-semibold mb-4">For emergencies call</h3>
                <div class="bg-teal-100 text-teal-800 p-4 rounded">(031) 5914042</div>

                <div class="mt-6">
                    <h4 class="font-semibold">Clinic Hours</h4>
                    <ul class="mt-3 text-sm text-gray-600 space-y-2">
                        <li class="flex justify-between"><span>Mon - Fri</span><span>08:00 - 16:00</span></li>
                        <li class="flex justify-between"><span>Sat</span><span>09:00 - 12:00</span></li>
                        <li class="flex justify-between"><span>Sun</span><span>Closed</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Clinic Info / Visual -->
    <section class="relative">
    <div class="h-56 sm:h-72 md:h-96 bg-cover bg-center" style="background-image: url('{{ asset('assets/images/human.avif') }}');">
            <div class="h-full w-full bg-gradient-to-b from-transparent to-white/90"></div>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="container mx-auto px-6 lg:px-12 py-12">
        <h2 class="text-2xl font-bold">Our Services</h2>
        <div class="w-20 h-0.5 bg-teal-300 mt-3 mb-6"></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('assets/images/checkup.jpg') }}" alt="Service 1" class="w-full h-48 object-cover">
                <div class="p-6 text-center">
                    <h3 class="font-semibold">General Checkup</h3>
                    <p class="mt-2 text-sm text-gray-600">Pemeriksaan kesehatan rutin untuk anjing dan kucing.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('assets/images/surgery.jpg') }}" alt="Service 2" class="w-full h-48 object-cover">
                <div class="p-6 text-center">
                    <h3 class="font-semibold">Surgery & Care</h3>
                    <p class="mt-2 text-sm text-gray-600">Layanan bedah dengan ruang operasi steril dan perawatan pasca operasi.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('assets/images/emergency.jpg') }}" alt="Service 3" class="w-full h-48 object-cover">
                <div class="p-6 text-center">
                    <h3 class="font-semibold">Emergency Care</h3>
                    <p class="mt-2 text-sm text-gray-600">Pelayanan gawat darurat 24 jam untuk kasus kritis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="appointment" class="bg-teal-50 py-12">
        <div class="container mx-auto px-6 lg:px-12 text-center">
            <h3 class="text-xl font-bold">Butuh bantuan segera?</h3>
            <p class="mt-2 text-gray-700">Hubungi kami atau buat janji untuk konsultasi dengan dokter hewan.</p>
            <div class="mt-6">
                <a href="#" class="inline-block bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded">Buat Janji Sekarang</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

</x-layout>