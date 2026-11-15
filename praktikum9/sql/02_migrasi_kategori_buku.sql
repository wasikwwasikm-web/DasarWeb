-- TAMBAHAN LATIHAN 7.4 #4:
-- Jalankan sekali pada database Praktikum 9 yang sudah memiliki kolom buku.kategori.
CREATE TABLE IF NOT EXISTS kategori_buku (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(50) NOT NULL UNIQUE,
    deskripsi VARCHAR(255)
);

INSERT INTO kategori_buku (nama)
SELECT DISTINCT btrim(kategori)
FROM buku
WHERE kategori IS NOT NULL AND btrim(kategori) <> ''
ON CONFLICT (nama) DO NOTHING;

ALTER TABLE buku ADD COLUMN IF NOT EXISTS kategori_id INTEGER;

UPDATE buku AS b
SET kategori_id = kb.id
FROM kategori_buku AS kb
WHERE b.kategori_id IS NULL AND btrim(b.kategori) = kb.nama;

DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM pg_constraint
        WHERE conname = 'buku_kategori_id_fkey'
          AND conrelid = 'buku'::regclass
    ) THEN
        ALTER TABLE buku
            ADD CONSTRAINT buku_kategori_id_fkey
            FOREIGN KEY (kategori_id) REFERENCES kategori_buku(id) ON DELETE RESTRICT;
    END IF;
END;
$$;
