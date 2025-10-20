<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-teal-700 hover:to-teal-800 focus:from-teal-700 focus:to-teal-800 active:from-teal-800 active:to-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transform hover:scale-105 shadow-lg hover:shadow-xl transition duration-200 ease-in-out']) }}>
    {{ $slot }}
</button>
