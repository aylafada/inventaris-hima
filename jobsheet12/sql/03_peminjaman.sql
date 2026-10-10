

-- 1. Tabel anggota (peminjam yang terdaftar)
CREATE TABLE IF NOT EXISTS anggota (
    id_anggota SERIAL PRIMARY KEY,
    nim        VARCHAR(20)  NOT NULL UNIQUE,
    nama       VARCHAR(100) NOT NULL,
    no_hp      VARCHAR(20)
);

-- 2. Hubungkan peminjaman -> anggota (foreign key).
--    NULLABLE agar data lama (hanya punya nama_peminjam) tetap valid.
ALTER TABLE peminjaman
    ADD COLUMN IF NOT EXISTS id_anggota INTEGER
    REFERENCES anggota(id_anggota) ON DELETE RESTRICT;

-- 3. Index untuk riwayat per anggota & statistik peminjaman aktif
CREATE INDEX IF NOT EXISTS peminjaman_id_anggota_idx ON peminjaman (id_anggota);
CREATE INDEX IF NOT EXISTS peminjaman_status_idx     ON peminjaman (status);

-- 4. Kunci tabel dari Data API Supabase (publishable/anon key bersifat publik).
--    Aplikasi memakai koneksi PDO langsung, jadi tidak terpengaruh.
ALTER TABLE anggota ENABLE ROW LEVEL SECURITY;
DO $$
BEGIN
    -- Role anon/authenticated hanya ada di Supabase; dilewati di Postgres biasa (mis. lokal)
    IF EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'anon') THEN
        EXECUTE 'REVOKE ALL ON TABLE anggota FROM anon, authenticated';
    END IF;
END $$;

-- 5. Data contoh (dilewati jika NIM sudah ada)
INSERT INTO anggota (nim, nama, no_hp) VALUES
    ('A0001', 'Aylafada',       '081234567801'),
    ('A0002', 'Budi Santoso',   '081234567802'),
    ('A0003', 'Citra Lestari',  '081234567803')
ON CONFLICT (nim) DO NOTHING;
