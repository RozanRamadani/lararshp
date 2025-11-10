# Icon Migration - Lordicon to Flaticon

## Overview
Project ini telah berhasil dimigrasi dari Lordicon ke Flaticon UIcons. Semua komponen `<x-lordicon>` telah diganti dengan tag `<i class="fi fi-...">` Flaticon.

## Icon Mapping
Berikut adalah pemetaan icon dari Lordicon ke Flaticon yang digunakan di project:

| Lordicon Name | Flaticon Class | Deskripsi |
|--------------|----------------|-----------|
| `owner` | `fi fi-rr-user` | Icon user/pemilik |
| `pet` | `fi fi-rr-paw` | Icon paw/hewan peliharaan |
| `dog` | `fi fi-rr-dog` | Icon anjing |
| `cat` | `fi fi-rr-cat` | Icon kucing |
| `statistics` | `fi fi-rr-chart-line` | Icon statistik/chart |
| `activity` | `fi fi-rr-chart-line` | Icon aktivitas |
| `report` | `fi fi-rr-chart-line` | Icon laporan |
| `calendar` | `fi fi-rr-calendar` | Icon kalender |
| `vet` | `fi fi-rr-stethoscope` | Icon dokter hewan |
| `stethoscope` | `fi fi-rr-stethoscope` | Icon stetoskop |
| `users` | `fi fi-rr-users` | Icon multiple users |
| `category` | `fi fi-rr-apps` | Icon kategori/apps |
| `medicine` | `fi fi-rr-prescription-bottle` | Icon obat/medicine |
| `medical` | `fi fi-rr-prescription-bottle` | Icon medis |
| `clinic` | `fi fi-rr-hospital` | Icon klinik/rumah sakit |
| `shield` | `fi fi-rr-shield` | Icon shield/role |
| `list` | `fi fi-rr-list` | Icon list |
| `user-check` | `fi fi-rr-user-check` | Icon user verified |
| `home` | `fi fi-rr-home` | Icon home |
| `check` | `fi fi-rr-check` | Icon check/centang |
| `x` | `fi fi-rr-cross` | Icon close/silang |
| `plus` | `fi fi-rr-plus` | Icon tambah |
| `edit` | `fi fi-rr-edit` | Icon edit |
| `trash` | `fi fi-rr-trash` | Icon hapus |

## Usage Example

### Before (Lordicon):
```blade
<x-lordicon icon="pet" trigger="hover" size="32" class="text-teal-600" />
```

### After (Flaticon):
```blade
<i class="fi fi-rr-paw text-teal-600" style="font-size: 32px;"></i>
```

## Flaticon Setup
Flaticon CSS sudah diimport di `resources/css/app.css`:
```css
@import "@flaticon/flaticon-uicons/css/all/all.css";
```

Pastikan menjalankan build setelah perubahan:
```bash
npm run dev
# atau untuk production
npm run build
```

## Files Modified
Total 15 file blade yang diupdate:
- `resources/views/dashboard.blade.php`
- `resources/views/admin/data/index.blade.php`
- `resources/views/admin/jenis-hewan/index.blade.php`
- `resources/views/admin/jenis-hewan/create.blade.php`
- `resources/views/admin/ras-hewan/index.blade.php`
- `resources/views/admin/ras-hewan/edit.blade.php`
- `resources/views/admin/kategori/index.blade.php`
- `resources/views/admin/kategori-klinis/index.blade.php`
- `resources/views/admin/kode-tindakan-terapi/index.blade.php`
- `resources/views/admin/pet/index.blade.php`
- `resources/views/admin/pemilik/create.blade.php`
- `resources/views/admin/pet/create.blade.php`
- `resources/views/admin/role/index.blade.php`
- `resources/views/admin/user-role/index.blade.php`
- `resources/views/components/breadcrumb.blade.php`

## Notes
- Komponen `<x-lordicon>` sudah dihapus dari `resources/views/components/`
- Semua icon sekarang menggunakan Flaticon dengan style inline `font-size`
- View cache sudah dibersihkan dengan `php artisan view:clear`
