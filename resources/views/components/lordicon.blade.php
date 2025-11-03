@props([
    'icon' => '',
    'trigger' => 'hover',
    'colors' => null,
    'size' => '32',
    'class' => ''
])

@php
    // Lordicon library mapping
    $lordicons = [
        // Actions
        'plus' => 'https://cdn.lordicon.com/jvihlqtw.json',
        'edit' => 'https://cdn.lordicon.com/pflszboa.json',
        'trash' => 'https://cdn.lordicon.com/skkahier.json',
        'delete' => 'https://cdn.lordicon.com/skkahier.json',
        'check' => 'https://cdn.lordicon.com/oqdmuxru.json',
        'x' => 'https://cdn.lordicon.com/nqtddedc.json',
        'search' => 'https://cdn.lordicon.com/kkvxgpti.json',
        'arrow-left' => 'https://cdn.lordicon.com/zmkotitn.json',
        'eye' => 'https://cdn.lordicon.com/dicvhxpz.json',

        // Pet Care
        'pet' => 'https://cdn.lordicon.com/iltqorsz.json',
        'dog' => 'https://cdn.lordicon.com/iltqorsz.json',
        'cat' => 'https://cdn.lordicon.com/gkryirhd.json',
        'owner' => 'https://cdn.lordicon.com/kthelypq.json',
        'vet' => 'https://cdn.lordicon.com/egiwmiit.json',
        'clinic' => 'https://cdn.lordicon.com/gqdnbnwt.json',
        'medical' => 'https://cdn.lordicon.com/iphtspzl.json',
        'stethoscope' => 'https://cdn.lordicon.com/iphtspzl.json',
        'medicine' => 'https://cdn.lordicon.com/jvucoldz.json',
        'first-aid' => 'https://cdn.lordicon.com/jvucoldz.json',

        // Data & Navigation
        'statistics' => 'https://cdn.lordicon.com/fhtaantg.json',
        'activity' => 'https://cdn.lordicon.com/pndisohp.json',
        'calendar' => 'https://cdn.lordicon.com/whrxobsb.json',
        'report' => 'https://cdn.lordicon.com/nocovwne.json',
        'list' => 'https://cdn.lordicon.com/gqdnbnwt.json',
        'category' => 'https://cdn.lordicon.com/iykrupvk.json',
        'puzzle' => 'https://cdn.lordicon.com/iltqorsz.json',

        // Users & Security
        'users' => 'https://cdn.lordicon.com/bhfjfgqz.json',
        'user-check' => 'https://cdn.lordicon.com/ajkxzzfb.json',
        'shield' => 'https://cdn.lordicon.com/gfpeqxlw.json',
        'home' => 'https://cdn.lordicon.com/laqlvddb.json',
        'alert-circle' => 'https://cdn.lordicon.com/keaiyjcx.json',
        // Example pro icons (placeholders) - replace URLs with your Lordicon Pro JSON URLs
        // e.g. 'scalpel' => 'https://cdn.lordicon.com/your-pro-id.json'
        'scalpel' => 'https://cdn.lordicon.com/your-pro-scalpel.json',
        'lab' => 'https://cdn.lordicon.com/your-pro-lab.json',
        'xray' => 'https://cdn.lordicon.com/your-pro-xray.json',
        'grooming' => 'https://cdn.lordicon.com/your-pro-grooming.json',
        'oncology' => 'https://cdn.lordicon.com/your-pro-oncology.json',
        'phone' => 'https://cdn.lordicon.com/your-pro-phone.json',
        'whatsapp' => 'https://cdn.lordicon.com/your-pro-whatsapp.json',
        'clock' => 'https://cdn.lordicon.com/your-pro-clock.json',
        'heart' => 'https://cdn.lordicon.com/your-pro-heart.json',
    ];

    $hasLordicon = array_key_exists($icon, $lordicons);
    $iconSrc = $hasLordicon ? $lordicons[$icon] : null;

    // If configured to only use free icons, check allowed list and force fallback if not allowed
    $useFreeOnly = config('lordicon.use_free_only', true);
    $allowedIcons = config('lordicon.allowed_icons', []);
    if ($useFreeOnly && $hasLordicon && !in_array($icon, $allowedIcons)) {
        $hasLordicon = false;
        $iconSrc = null;
    }

    // If the icon is explicitly listed as a paid icon, force fallback to Freepik
    $paidIcons = config('lordicon.paid_icons', []);
    if ($hasLordicon && is_array($paidIcons) && in_array($icon, $paidIcons)) {
        $hasLordicon = false;
        $iconSrc = null;
    }

    // Extract color from Tailwind class if not explicitly set
    if ($colors === null) {
        // Default colors based on common Tailwind color classes
        if (str_contains($class, 'text-teal')) {
            $colors = 'primary:#14b8a6,secondary:#0d9488';
        } elseif (str_contains($class, 'text-blue')) {
            $colors = 'primary:#3b82f6,secondary:#2563eb';
        } elseif (str_contains($class, 'text-green')) {
            $colors = 'primary:#10b981,secondary:#059669';
        } elseif (str_contains($class, 'text-purple')) {
            $colors = 'primary:#a855f7,secondary:#9333ea';
        } elseif (str_contains($class, 'text-red')) {
            $colors = 'primary:#ef4444,secondary:#dc2626';
        } elseif (str_contains($class, 'text-yellow')) {
            $colors = 'primary:#f59e0b,secondary:#d97706';
        } elseif (str_contains($class, 'text-indigo')) {
            $colors = 'primary:#6366f1,secondary:#4f46e5';
        } elseif (str_contains($class, 'text-emerald')) {
            $colors = 'primary:#10b981,secondary:#059669';
        } elseif (str_contains($class, 'text-white')) {
            $colors = 'primary:#ffffff,secondary:#f3f4f6';
        } else {
            $colors = 'primary:#121331,secondary:#08a88a';
        }
    }
@endphp

@if($hasLordicon)
    <lord-icon
        src="{{ $iconSrc }}"
        trigger="{{ $trigger }}"
        colors="{{ $colors }}"
        style="width:{{ $size }}px;height:{{ $size }}px"
        {{ $attributes->merge(['class' => $class]) }}>
    </lord-icon>
@else
    {{-- Fallback to Freepik proxy. Store FREEPIK_API_KEY in .env and configure FREEPIK_SEARCH_ENDPOINT if needed. --}}
    <img src="{{ route('freepik.proxy', ['query' => $icon]) }}" alt="{{ $icon }}" style="width:{{ $size }}px;height:{{ $size }}px" {{ $attributes->merge(['class' => $class]) }} onerror="this.style.display='none'"/>
@endif
