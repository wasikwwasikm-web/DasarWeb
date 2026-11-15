-- Pastikan kolom tambahan buku dan anggota tersedia.
ALTER TABLE buku
    ADD COLUMN IF NOT EXISTS isbn VARCHAR(50),
    ADD COLUMN IF NOT EXISTS kategori VARCHAR(50),
    ADD COLUMN IF NOT EXISTS penerbit VARCHAR(255),
    ADD COLUMN IF NOT EXISTS deskripsi TEXT,
    ADD COLUMN IF NOT EXISTS bahasa VARCHAR(50) DEFAULT 'Indonesia';

ALTER TABLE anggota
    ADD COLUMN IF NOT EXISTS no_hp VARCHAR(30);
