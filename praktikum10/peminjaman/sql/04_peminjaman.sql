-- [New] Tabel transaksi peminjaman buku.
CREATE TABLE IF NOT EXISTS peminjaman (
    id SERIAL PRIMARY KEY,
    buku_id INTEGER NOT NULL REFERENCES buku(id),
    anggota_id INTEGER NOT NULL REFERENCES anggota(id),
    tanggal_pinjam DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_kembali DATE
);

CREATE INDEX IF NOT EXISTS idx_peminjaman_aktif
    ON peminjaman (id)
    WHERE tanggal_kembali IS NULL;
