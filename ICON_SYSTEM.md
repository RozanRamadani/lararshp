# Icon System Documentation - RSHP Project

## 🎨 **Custom Icon Component untuk Project RSHP**

Project Rumah Sakit Hewan UNAIR (RSHP) menggunakan icon system yang berbasis **Heroicons** dan **custom SVG** untuk tampilan yang konsisten dan profesional tanpa memerlukan external dependencies atau attribution.

### **📦 Icon Component**

#### **Penggunaan Dasar**
```blade
<x-icon type="pet" size="w-8 h-8" class="text-teal-600" />
```

#### **Available Icon Types**
| Type | Penggunaan | Konteks |
|------|------------|---------|
| `pet` | General pet/hewan | Dashboard statistics, general animal references |
| `owner` | Pemilik hewan | User profiles, owner data |
| `dog` | Anjing | Species-specific displays |
| `cat` | Kucing | Species-specific displays |
| `bird` | Burung | Species-specific displays |
| `rabbit` | Kelinci | Species-specific displays |
| `reptile` | Reptil | Species-specific displays |
| `vet` | Veterinary | Medical staff, doctor references |
| `medical` | Medical equipment | Health services, medical tools |
| `clinic` | Clinic building | Facility references |
| `statistics` | Data/charts | Dashboard analytics |
| `calendar` | Calendar/dates | Appointments, scheduling |
| `activity` | Activity/actions | Recent activities, quick actions |

#### **Size Options**
- `w-4 h-4` - Small icons (16px)
- `w-6 h-6` - Medium icons (24px) 
- `w-8 h-8` - Large icons (32px)
- `w-12 h-12` - Extra large icons (48px)

### **🎯 Implementasi dalam Project**

#### **1. Dashboard (`/dashboard`)**
```blade
<!-- Statistics Card -->
<div class="p-3 bg-gradient-to-br from-teal-100 to-teal-200 rounded-xl shadow-sm">
    <x-icon type="owner" size="w-8 h-8" class="text-teal-600" />
</div>

<!-- Quick Actions -->
<div class="p-2 bg-gradient-to-br from-teal-100 to-teal-200 rounded-lg mr-3">
    <x-icon type="cat" size="w-6 h-6" class="text-teal-600" />
</div>
```

#### **2. Data Jenis Hewan (`/admin/jenis-hewan`)**
```blade
<!-- Dynamic Icon berdasarkan jenis hewan -->
<x-icon 
    type="{{ 
        stripos($jenis->nama_jenis_hewan, 'anjing') !== false ? 'dog' : 
        (stripos($jenis->nama_jenis_hewan, 'kucing') !== false ? 'cat' : 'pet')
    }}" 
    size="w-8 h-8" 
    class="text-blue-600"
/>
```

#### **3. Data Pemilik (`/admin/pemilik`)**
```blade
<!-- Owner profile icon -->
<x-icon type="owner" size="w-6 h-6" class="text-teal-600" />
```

### **🎨 Design System**

#### **Color Scheme**
```css
/* Primary Colors */
Teal: #0891b2, #06b6d4
Blue: #3b82f6
Green: #10b981
Yellow: #f59e0b

/* Gradient Backgrounds */
.bg-gradient-to-br from-teal-100 to-teal-200
.bg-gradient-to-br from-blue-100 to-blue-200
.bg-gradient-to-br from-green-100 to-green-200
.bg-gradient-to-br from-yellow-100 to-yellow-200
```

#### **Interactive Effects**
```css
/* Hover animations */
.transform hover:scale-105 transition-transform duration-200

/* Card hover effects */
.hover:bg-gradient-to-r hover:from-teal-50 hover:to-teal-100 
.transition-all duration-300 transform hover:scale-105 hover:shadow-md
```

### **🔧 Technical Details**

#### **Component Structure**
```php
// File: resources/views/components/icon.blade.php
@props(['type' => 'pet', 'size' => 'w-8 h-8', 'class' => ''])

@php
$iconSvgs = [
    'pet' => '<svg class="'.$size.' '.$class.'">...</svg>',
    // ... other icons
];
$iconSvg = $iconSvgs[$type] ?? $iconSvgs['pet'];
@endphp

{!! $iconSvg !!}
```

#### **SVG Source**
- All icons based on **Heroicons** (MIT License)
- Custom modifications for veterinary context
- Consistent stroke-width: 2
- Optimized viewBox: 0 0 24 24

### **✨ Features**

#### **1. Automatic Fallback**
```php
// Jika type tidak ditemukan, otomatis fallback ke 'pet'
$iconSvg = $iconSvgs[$type] ?? $iconSvgs['pet'];
```

#### **2. Dynamic Icon Selection**
```blade
<!-- Berdasarkan nama jenis hewan -->
type="{{ 
    stripos($jenis->nama_jenis_hewan, 'anjing') !== false ? 'dog' : 
    (stripos($jenis->nama_jenis_hewan, 'kucing') !== false ? 'cat' : 'pet')
}}"
```

#### **3. Consistent Styling**
```blade
<!-- Semua icon menggunakan class yang konsisten -->
class="{{ $size }} {{ $class }}"
```

### **📱 Responsive Behavior**

Icons automatically responsive dengan Tailwind:
- **Desktop**: Full size display
- **Tablet**: Proportional scaling
- **Mobile**: Compact display dengan ukuran yang sesuai

### **🚀 Performance**

- ✅ **Zero external dependencies**
- ✅ **Inline SVG** untuk loading cepat
- ✅ **No HTTP requests** untuk icons
- ✅ **Cacheable** with browser cache
- ✅ **Lightweight** - hanya SVG yang diperlukan

### **🔄 Maintenance**

#### **Menambah Icon Baru**
1. Pilih SVG dari Heroicons atau buat custom
2. Add ke array `$iconSvgs` di component
3. Test dengan `<x-icon type="new_type" />`

#### **Update Icon Existing**
1. Edit SVG di array `$iconSvgs`
2. Pastikan viewBox dan stroke-width konsisten
3. Test di semua penggunaan

### **📋 Best Practices**

1. **Konsistensi Size**: Gunakan size standard (w-4, w-6, w-8, w-12)
2. **Color Context**: Sesuaikan warna dengan konteks (teal untuk primary, blue untuk secondary, dll)
3. **Semantic Naming**: Gunakan type yang sesuai dengan konteks
4. **Fallback**: Selalu ada fallback ke 'pet' icon
5. **Performance**: Hindari icon terlalu besar untuk mobile

---

**✅ No Attribution Required**
**✅ MIT Licensed (Heroicons)**
**✅ Custom Modifications Allowed**

*Created for RSHP UNAIR Project - Professional Veterinary Management System*