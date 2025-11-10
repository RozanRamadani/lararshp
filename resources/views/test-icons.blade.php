<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Flaticon Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { padding: 40px; font-family: sans-serif; }
        .test-icon { margin: 20px; }
        .icon-label { display: inline-block; width: 200px; }
    </style>
</head>
<body>
    <h1>Flaticon UIcons Test Page</h1>

    <p>Jika icon muncul dengan benar, Anda akan melihat icon (bukan kotak kosong):</p>

    <div class="test-icon">
        <span class="icon-label">fi fi-rr-home:</span>
        <i class="fi fi-rr-home" style="font-size: 32px;"></i>
    </div>

    <div class="test-icon">
        <span class="icon-label">fi fi-rr-user:</span>
        <i class="fi fi-rr-user" style="font-size: 32px;"></i>
    </div>

    <div class="test-icon">
        <span class="icon-label">fi fi-rr-paw:</span>
        <i class="fi fi-rr-paw" style="font-size: 32px;"></i>
    </div>

    <div class="test-icon">
        <span class="icon-label">fi fi-rr-dog:</span>
        <i class="fi fi-rr-dog" style="font-size: 32px;"></i>
    </div>

    <div class="test-icon">
        <span class="icon-label">fi fi-rr-cat:</span>
        <i class="fi fi-rr-cat" style="font-size: 32px;"></i>
    </div>

    <div class="test-icon">
        <span class="icon-label">fi fi-rr-stethoscope:</span>
        <i class="fi fi-rr-stethoscope" style="font-size: 32px;"></i>
    </div>

    <hr>

    <h2>Debug Info:</h2>
    <p>Jika icon tidak muncul:</p>
    <ol>
        <li>Buka DevTools (F12) → Network tab</li>
        <li>Refresh halaman (Ctrl+Shift+R untuk hard refresh)</li>
        <li>Cari file CSS (app-*.css)</li>
        <li>Cek apakah file berukuran besar (~1.2MB) - berarti Flaticon sudah termuat</li>
        <li>Cek juga file font (.woff2) apakah dimuat</li>
    </ol>

    <p><a href="{{ route('admin.data.index') }}">← Kembali ke Dashboard</a></p>
</body>
</html>
