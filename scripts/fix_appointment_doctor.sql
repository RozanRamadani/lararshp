-- Script untuk mengisi idrole_user yang kosong pada temu_dokter
-- Akan assign ke dokter/perawat pertama yang aktif

-- Cek appointment yang belum punya dokter assigned
SELECT
    td.idreservasi_dokter,
    td.waktu_daftar,
    td.status,
    p.nama_hewan,
    pm.nama as pemilik,
    td.idrole_user
FROM temu_dokter td
JOIN pet p ON td.idpet = p.idpet
JOIN pemilik pm ON p.idpemilik = pm.idpemilik
WHERE td.idrole_user IS NULL
ORDER BY td.waktu_daftar DESC;

-- Get dokter/perawat yang aktif
SELECT
    ru.idrole_user,
    u.nama,
    r.nama_role,
    ru.status
FROM role_user ru
JOIN user u ON ru.iduser = u.iduser
JOIN role r ON ru.idrole = r.idrole
WHERE r.nama_role IN ('Dokter', 'Perawat')
AND ru.status = 1;

-- Update appointment yang kosong dengan dokter pertama yang aktif
-- UNCOMMENT untuk execute:
/*
UPDATE temu_dokter
SET idrole_user = (
    SELECT ru.idrole_user
    FROM role_user ru
    JOIN role r ON ru.idrole = r.idrole
    WHERE r.nama_role = 'Dokter'
    AND ru.status = 1
    LIMIT 1
)
WHERE idrole_user IS NULL;
*/

-- Atau assign berdasarkan status appointment:
-- Appointment yang sudah selesai/dalam proses assign ke dokter
-- Appointment yang menunggu assign ke perawat/resepsionis
/*
UPDATE temu_dokter td
SET idrole_user = (
    SELECT ru.idrole_user
    FROM role_user ru
    JOIN role r ON ru.idrole = r.idrole
    WHERE r.nama_role = CASE
        WHEN td.status IN (2, 3, 4) THEN 'Dokter'  -- Pemeriksaan, Treatment, Selesai
        ELSE 'Perawat'  -- Menunggu, Check-in, Batal
    END
    AND ru.status = 1
    LIMIT 1
)
WHERE td.idrole_user IS NULL;
*/
