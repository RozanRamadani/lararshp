@props(['items' => []])

<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <!-- Dashboard (Home) -->
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                <i class="fi fi-rr-home mr-2" style="font-size: 16px;"></i>
                Dashboard
            </a>
        </li>
        
        <!-- Dynamic breadcrumb items -->
        @foreach($items as $item)
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 transition-colors duration-200">
                        {{ $item['name'] }}
                    </a>
                @else
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                        {{ $item['name'] }}
                    </span>
                @endif
            </div>
        </li>
        @endforeach
    </ol>
</nav>