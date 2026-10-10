-- Jobsheet 11: tabel session untuk Vercel (serverless)
-- Jalankan sekali di Supabase -> SQL Editor.
-- (Aplikasi juga membuatnya otomatis bila belum ada, tetapi lebih baik dibuat manual.)

CREATE TABLE IF NOT EXISTS sessions (
    id            VARCHAR(128) PRIMARY KEY,
    data          TEXT NOT NULL,
    last_activity BIGINT NOT NULL
);

CREATE INDEX IF NOT EXISTS sessions_last_activity_idx ON sessions (last_activity);

-- WAJIB: kunci tabel dari Data API Supabase.
-- Publishable (anon) key bersifat publik; tanpa RLS siapa pun bisa membaca
-- isi session (termasuk ID session petugas/admin) lewat /rest/v1/sessions.
-- Aplikasi tetap bisa memakai tabel ini karena koneksi PDO memakai user database,
-- bukan anon key.
ALTER TABLE sessions ENABLE ROW LEVEL SECURITY;
DO $$
BEGIN
    -- Role anon/authenticated hanya ada di Supabase; dilewati di Postgres biasa (mis. lokal)
    IF EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'anon') THEN
        EXECUTE 'REVOKE ALL ON TABLE sessions FROM anon, authenticated';
    END IF;
END $$;
