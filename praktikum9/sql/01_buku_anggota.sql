-- TAMBAHAN LATIHAN 7.4 #4: tabel kategori sebagai entitas CRUD baru.
CREATE TABLE IF NOT EXISTS kategori_buku (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(50) NOT NULL UNIQUE,
    deskripsi VARCHAR(255)
);

INSERT INTO kategori_buku (nama, deskripsi)
VALUES
    ('fiksi', 'Buku cerita dan karya fiksi'),
    ('non-fiksi', 'Buku berdasarkan fakta dan pengetahuan'),
    ('referensi', 'Buku rujukan dan referensi')
ON CONFLICT (nama) DO NOTHING;

CREATE TABLE IF NOT EXISTS buku (
    id SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    pengarang VARCHAR(255) NOT NULL,
    tahun INTEGER NOT NULL,
    isbn VARCHAR(50),
    stok INTEGER NOT NULL DEFAULT 0,
    kategori_id INTEGER REFERENCES kategori_buku(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS anggota (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    no_anggota VARCHAR(50) NOT NULL UNIQUE,
    alamat VARCHAR(255),
    no_hp VARCHAR(30)
);
