<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title ?? 'RSHP UNAIR' }} - Rumah Sakit Hewan Universitas Airlangga</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
</head>

<body class="h-full">
    <div class="min-h-full">
        <x-navbar></x-navbar>

        @if(isset($showHeader) && $showHeader)
            <x-header>{{ $title ?? 'RSHP UNAIR' }}</x-header>
            <main>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        @else
            <main>
                {{ $slot }}
            </main>
        @endif
    </div>
</body>

</html>
