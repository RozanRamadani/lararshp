# Lordicon Integration Guide

## Overview
Project ini menggunakan **Lordicon** - animated icon library yang memberikan pengalaman visual yang lebih menarik dengan animasi smooth dan interaktif.

## Setup

### 1. CDN Script
Lordicon sudah diintegrasikan melalui CDN di layout files:
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`

```html
<script src="https://cdn.lordicon.com/lordicon.js"></script>
```

### 2. Blade Component
Component `<x-lordicon>` tersedia di:
- `resources/views/components/lordicon.blade.php`

## Usage

### Basic Usage
```blade
<x-lordicon 
    icon="pet" 
    trigger="hover" 
    size="32" 
    class="text-teal-600" 
/>
```

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `icon` | string | required | Nama icon dari library (lihat daftar di bawah) |
| `trigger` | string | `hover` | Animation trigger: `hover`, `click`, `loop`, `morph` |
| `size` | string | `32` | Ukuran icon dalam pixel |
| `colors` | string | auto | Color palette (auto-detect dari Tailwind class) |
| `class` | string | `''` | Additional Tailwind CSS classes |

### Animation Triggers

1. **hover** - Animasi saat mouse hover (recommended untuk cards, buttons)
   ```blade
   <x-lordicon icon="pet" trigger="hover" size="32" />
   ```

2. **click** - Animasi saat diklik (recommended untuk action buttons)
   ```blade
   <x-lordicon icon="plus" trigger="click" size="24" />
   ```

3. **loop** - Animasi terus-menerus (hati-hati dengan performance)
   ```blade
   <x-lordicon icon="activity" trigger="loop" size="48" />
   ```

4. **morph** - Smooth transition antar state
   ```blade
   <x-lordicon icon="check" trigger="morph" size="20" />
   ```

## Available Icons

### Actions (9 icons)
- `plus` - Add/Create button
- `edit` - Edit/Modify button
- `trash` / `delete` - Delete/Remove button
- `check` - Success/Confirm
- `x` - Close/Cancel/Error
- `search` - Search functionality
- `arrow-left` - Back/Return navigation
- `eye` - View/Preview

### Pet Care (10 icons)
- `pet` - Generic pet/animal
- `dog` - Dog specific
- `cat` - Cat specific
- `owner` - Pet owner/customer
- `vet` - Veterinarian/medical professional
- `clinic` - Veterinary clinic/facility
- `medical` / `stethoscope` - Medical examination
- `medicine` / `first-aid` - Treatment/medication

### Data & Navigation (7 icons)
- `statistics` - Stats/Analytics
- `activity` - Recent activity/timeline
- `calendar` - Schedule/appointments
- `report` - Reports/documents
- `list` - Lists/tables
- `category` - Categories/classification
- `puzzle` - Modular components

### Users & Security (5 icons)
- `users` - User management/group
- `user-check` - Role assignments
- `shield` - Security/permissions
- `home` - Homepage/dashboard
- `alert-circle` - Warnings/alerts

## Color Auto-Detection

Component secara otomatis mendeteksi warna dari Tailwind class:

```blade
<!-- Teal color -->
<x-lordicon icon="pet" size="32" class="text-teal-600" />

<!-- Blue color -->
<x-lordicon icon="users" size="32" class="text-blue-600" />

<!-- Red color -->
<x-lordicon icon="trash" size="24" class="text-red-600" />
```

### Supported Tailwind Colors:
- `text-teal-*` → Teal (#14b8a6, #0d9488)
- `text-blue-*` → Blue (#3b82f6, #2563eb)
- `text-green-*` / `text-emerald-*` → Green (#10b981, #059669)
- `text-purple-*` → Purple (#a855f7, #9333ea)
- `text-red-*` → Red (#ef4444, #dc2626)
- `text-yellow-*` → Yellow (#f59e0b, #d97706)
- `text-indigo-*` → Indigo (#6366f1, #4f46e5)
- `text-white` → White (#ffffff, #f3f4f6)

## Common Use Cases

### 1. Statistics Cards
```blade
<div class="p-4 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl">
    <x-lordicon icon="pet" trigger="hover" size="32" class="text-teal-600" />
</div>
<div class="ml-4">
    <h4 class="text-2xl font-bold">{{ $count }}</h4>
    <p class="text-sm text-gray-600">Total Pets</p>
</div>
```

### 2. Action Buttons
```blade
<!-- Add Button -->
<a href="{{ route('admin.kategori.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg flex items-center">
    <x-lordicon icon="plus" trigger="click" size="20" class="mr-2" />
    Tambah Data
</a>

<!-- Edit Button -->
<a href="{{ route('admin.kategori.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800">
    <x-lordicon icon="edit" trigger="hover" size="20" />
</a>

<!-- Delete Button -->
<button class="text-red-600 hover:text-red-800">
    <x-lordicon icon="trash" trigger="hover" size="20" />
</button>
```

### 3. Flash Messages
```blade
<!-- Success Message -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
    <div class="flex items-center">
        <x-lordicon icon="check" trigger="morph" size="20" class="mr-2" />
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

<!-- Error Message -->
@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
    <div class="flex items-center">
        <x-lordicon icon="x" trigger="morph" size="20" class="mr-2" />
        <span>{{ session('error') }}</span>
    </div>
</div>
@endif
```

### 4. Navigation Cards
```blade
<a href="{{ route('admin.pets.index') }}" class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all">
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 bg-gradient-to-br from-green-100 to-green-200 rounded-xl group-hover:scale-110 transition-transform">
            <x-lordicon icon="dog" trigger="hover" size="32" class="text-green-600" />
        </div>
    </div>
    <h3 class="text-lg font-semibold text-gray-900">Pets Management</h3>
    <p class="text-sm text-gray-600">Manage all registered pets</p>
</a>
```

### 5. Empty States
```blade
<div class="text-center py-8">
    <x-lordicon icon="activity" trigger="loop" size="64" class="mx-auto mb-3 text-gray-300" />
    <p class="text-gray-500 text-sm">No recent activity</p>
</div>
```

## Size Guidelines

| Context | Recommended Size | Example |
|---------|------------------|---------|
| Small buttons/inline | 16px - 20px | Action buttons in tables |
| Medium buttons/cards | 24px - 32px | Navigation cards, form buttons |
| Large stats/features | 48px - 64px | Dashboard statistics, hero sections |
| Empty states | 64px - 96px | No data illustrations |

## Performance Tips

1. **Avoid excessive `loop` triggers** - Use `hover` or `click` instead
2. **Lazy load on large lists** - Consider pagination for icon-heavy tables
3. **Cache CDN script** - Already optimized via CDN delivery
4. **Limit simultaneous animations** - Lordicon handles this automatically

## Migration from Tabler Icons

All Tabler icons have been successfully migrated to Lordicon:

### Before (Tabler)
```blade
<x-tabler-icon name="pet" class="w-8 h-8 text-teal-600" />
```

### After (Lordicon)
```blade
<x-lordicon icon="pet" trigger="hover" size="32" class="text-teal-600" />
```

## Custom Colors (Optional)

Jika ingin override auto-detection:

```blade
<x-lordicon 
    icon="pet" 
    trigger="hover" 
    size="32" 
    colors="primary:#ff6b6b,secondary:#ee5a6f"
/>
```

## Troubleshooting

### Icon not showing?
1. Check if CDN script is loaded (view page source)
2. Verify icon name exists in the mapping (see component file)
3. Check browser console for errors

### Animation not working?
1. Ensure trigger value is valid: `hover`, `click`, `loop`, `morph`
2. Check if JavaScript is enabled
3. Clear browser cache

### Wrong colors?
1. Make sure Tailwind color class is included
2. Use supported color formats (see list above)
3. Override manually with `colors` prop if needed

## Browser Support

Lordicon works on all modern browsers:
- Chrome 60+
- Firefox 55+
- Safari 11+
- Edge 79+

## Resources

- **Official Lordicon Site**: https://lordicon.com/
- **Free Icons Library**: https://lordicon.com/icons
- **Documentation**: https://lordicon.com/docs
 
## Freepik Fallback (Server-side)

If a Lordicon mapping does not exist for a requested semantic icon name, the component will fall back to a server-side Freepik proxy which performs a search and returns an image.

Setup:
- Add your Freepik API key to `.env` as `FREEPIK_API_KEY`.
- If your Freepik integration uses a custom search endpoint, set `FREEPIK_SEARCH_ENDPOINT` in `.env` (defaults to `https://api.freepik.com/v1/search`).

Notes:
- The Freepik proxy is intended to keep API keys server-side and avoid exposing credentials to the browser.
- Behavior depends on the Freepik response format; if your integration returns JSON in a different shape, update `app/Http/Controllers/FreepikController.php` accordingly.

## Using Lordicon Free Account

If you are using a free Lordicon account, some animated icons may be restricted. To avoid serving icons that require a paid account, the project supports a "free-only" mode.

How it works:
- `config/lordicon.php` contains `use_free_only` (default true) and `allowed_icons` (whitelist of semantic icon names).
- When `LORDICON_USE_FREE_ONLY=true` (default), the Blade component will render Lordicon only for icons listed in `allowed_icons`. Other icon names automatically fall back to the Freepik proxy.

To change behavior:
- Edit `.env` to set `LORDICON_USE_FREE_ONLY=false` if you have a paid Lordicon plan and want to use all mapped icons.
- Edit `config/lordicon.php` to add/remove allowed icons.

Remember: Freepik fallback requires `FREEPIK_API_KEY` in `.env`.

---

**Last Updated**: November 3, 2025  
**Version**: 1.0.0  
**Project**: RSHP UNAIR - Pet Care Management System
