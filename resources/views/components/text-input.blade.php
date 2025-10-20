@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 bg-gray-50 hover:bg-white disabled:bg-gray-100 disabled:cursor-not-allowed']) }}>
