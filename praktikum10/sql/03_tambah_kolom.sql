-- Tambah kolom baru ke tabel buku
ALTER TABLE buku
ADD COLUMN IF NOT EXISTS penerbit VARCHAR(255),
ADD COLUMN IF NOT EXISTS deskripsi TEXT,
ADD COLUMN IF NOT EXISTS bahasa VARCHAR(50) DEFAULT 'Indonesia';
