-- 1. Hapus tabel lama jika sudah ada
DROP TABLE IF EXISTS peminjaman CASCADE;
DROP TABLE IF EXISTS barang CASCADE;
DROP TABLE IF EXISTS kategori CASCADE;

-- 2. Buat ulang tabel dari awal
CREATE TABLE kategori (
    id_kategori SERIAL PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE barang (
    id_barang SERIAL PRIMARY KEY,
    kode_barang VARCHAR(20) UNIQUE NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    id_kategori INTEGER NOT NULL REFERENCES kategori(id_kategori),
    jumlah INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE peminjaman (
    id_peminjaman SERIAL PRIMARY KEY,
    id_barang INTEGER NOT NULL REFERENCES barang(id_barang),
    nama_peminjam VARCHAR(100) NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE,
    status VARCHAR(30) NOT NULL DEFAULT 'Dipinjam'
);

-- 3. Masukkan data awal kategori
INSERT INTO kategori (nama_kategori) VALUES
('Elektronik'),
('Multimedia');

-- 4. Masukkan data awal barang (sesuai data awal)
INSERT INTO barang (kode_barang, nama_barang, id_kategori, jumlah) VALUES
('A001', 'Laptop', 1, 5),
('A002', 'Proyektor', 1, 2),
('A003', 'Kabel HDMI', 2, 6);

-- 5. Cek hasil data
SELECT barang.kode_barang, barang.nama_barang, kategori.nama_kategori, barang.jumlah 
FROM barang 
JOIN kategori ON barang.id_kategori = kategori.id_kategori;