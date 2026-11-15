CREATE TABLE IF NOT EXISTS buku (
    id SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(255) NOT NULL,
    tahun INTEGER NOT NULL,
    isbn VARCHAR(50),
    stok INTEGER NOT NULL DEFAULT 0,
    kategori VARCHAR(50),
    -- simpan waktu penambahan buku secara otomatis.
    tanggal_ditambahkan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tambahkan kolom juga pada tabel buku yang sudah lebih dulu dibuat.
ALTER TABLE buku
    ADD COLUMN IF NOT EXISTS tanggal_ditambahkan TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE IF NOT EXISTS anggota (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    no_anggota VARCHAR(50) NOT NULL UNIQUE,
    alamat VARCHAR(255),
    no_hp VARCHAR(30)
);
