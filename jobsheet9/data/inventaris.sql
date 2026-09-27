DROP TABLE IF EXISTS peminjaman CASCADE;
DROP TABLE IF EXISTS barang CASCADE;
DROP TABLE IF EXISTS kategori CASCADE;
DROP TABLE IF EXISTS users CASCADE;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'petugas'
);

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

INSERT INTO kategori (nama_kategori)
VALUES
('Elektronik'),
('Multimedia');

INSERT INTO barang (
    kode_barang,
    nama_barang,
    id_kategori,
    jumlah
)
VALUES
('A001', 'Laptop', 1, 5),
('A002', 'Proyektor', 1, 2),
('A003', 'Kabel HDMI', 2, 6);