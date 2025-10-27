<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand Section -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center mb-4">
                    <x-application-logo class="block h-8 w-auto fill-current text-teal-600" />
                    <span class="ml-3 text-xl font-bold text-gray-900">RSHP UNAIR</span>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">
                    Rumah Sakit Hewan Universitas Airlangga menyediakan layanan kesehatan hewan terbaik dengan teknologi modern dan tim medis berpengalaman.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-teal-600 transition-colors duration-200">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-teal-600 transition-colors duration-200">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.229 14.794 3.74 13.643 3.74 12.346s.489-2.448 1.386-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.897.875 1.386 2.026 1.386 3.323s-.489 2.448-1.386 3.345c-.875.807-2.026 1.297-3.323 1.297z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-teal-600 transition-colors duration-200">
                        <span class="sr-only">WhatsApp</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.520-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.485 3.488z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Navigasi</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('layanan') }}" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                            Layanan
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                                Dashboard
                            </a>
                        </li>
                        @if(auth()->user()->hasRole('Administrator'))
                            <li>
                                <a href="{{ route('admin.data.index') }}" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                                    Data Management
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasRole('Resepsionis'))
                            <li>
                                <a href="{{ route('resepsionis.pemilik.index') }}" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                                    Owners
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Kontak</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 text-teal-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-gray-600 text-sm">
                            Kampus C UNAIR<br>
                            Jl. Mulyorejo, Surabaya
                        </span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-teal-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-600 text-sm">(031) 5914042</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-teal-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-600 text-sm">ult@su.unair.ac.id</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 text-teal-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-gray-600 text-sm">
                            <div>Mon - Fri: 08:00 - 16:00</div>
                            <div>Sat: 09:00 - 12:00</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-600 text-sm">
                    <p>&copy; {{ date('Y') }} Rumah Sakit Hewan UNAIR. All rights reserved.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                            Privacy Policy
                        </a>
                        <a href="#" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                            Terms of Service
                        </a>
                        <a href="#" class="text-gray-600 hover:text-teal-600 transition-colors duration-200 text-sm">
                            Support
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Version Info -->
            <div class="mt-4 text-center">
                <p class="text-xs text-gray-500">
                    Made with ❤️ by Rozan
                </p>
            </div>
        </div>
    </div>
</footer>
