# Wireframe.md — SIMPUS-Mini

Dokumen ini berisi rancangan UI/UX untuk fitur-fitur SIMPUS-Mini
yang belum diimplementasikan. Menggunakan konvensi ASCII art.

---

## 1. Wireframe Halaman Login Petugas

```
+----------------------------------+
|            SIMPUS-Mini           |
|----------------------------------|
|                                  |
|         [ Login Petugas ]        |
|                                  |
|   Username : [________________]  |
|   Password : [________________]  |
|                                  |
|          [     Masuk      ]      |
|                                  |
| Belum punya akun? Daftar di sini |
|                                  |
+----------------------------------+
```

---

## 2. Wireframe Dashboard Petugas

```
+-------------------------------------------------------------------+
| SIMPUS-Mini Beranda | Buku | Anggota | Peminjaman | (Nama) Logout |
|-------------------------------------------------------------------|
|                                                                   |
|  [ Total Buku ]   [ Total Anggota ]   [ Sedang Dipinjam ]         |
|                                                                   |
|  Aksi Cepat:                                                      |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]                       |
|                                                                   |
|  Transaksi Terbaru                                                |
|  --------------------------------------------------------------   |
|  Anggota     | Buku            | Tgl Pinjam  | Status             |
|  --------------------------------------------------------------   |
|                                                                   |
+-------------------------------------------------------------------+
```

# Wireframe & User Flow — SIMPUS-Mini

## User Flow

### A. User Flow — Peminjaman Buku

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
-> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
-> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]
```

### B. User Flow — Pengembalian Buku

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
-> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1] -> [Kembali ke Dashboard]
```

---

## Wireframe Halaman

### Halaman Login

```
+--------------------------------+
|          SIMPUS-Mini           |
|--------------------------------|
|      [ Login Petugas ]         |
|                                |
| Username : [_____________]     |
| Password : [_____________]     |
|                                |
|        [ Masuk ]               |
|                                |
| Belum punya akun? Daftar disini|
+--------------------------------+
```

**Terjemahan ke HTML:**

---

| Elemen Wireframe       | Jadi HTML                             |
| ---------------------- | ------------------------------------- |
| `SIMPUS-Mini`          | `<header><h1>`                        |
| `[ Login Petugas ]`    | `<h2>` (judul section)                |
| `Username :`           | `<label>` + `<input type="text">`     |
| `Password :`           | `<label>` + `<input type="password">` |
| `[ Masuk ]`            | `<button type="submit">`              |
| `Belum punya akun?...` | `<p>` + link                          |

---

### Dashboard Petugas

```
+----------------------------------------------------------------------------+
| SIMPUS-Mini  Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
|----------------------------------------------------------------------------|
|  [Total Buku]   [Total Anggota]   [Sedang Dipinjam]                        |
|                                                                            |
|  Aksi Cepat:                                                               |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]                                |
|                                                                            |
|  Transaksi Terbaru                                                         |
|----------------------------------------------------------------------------|
|  Anggota | Buku | Tgl Pinjam | Status                                      |
+----------------------------------------------------------------------------+
```

### Form Peminjaman

```
+---------------------------------------+
|         Form Peminjaman Buku          |
|---------------------------------------|
|  Anggota : [ dropdown pilih anggota ] |
|  Buku    : [ dropdown, hanya stok>0 ] |
|  Tanggal Pinjam : [ auto: hari ini ]  |
|                                       |
|         [ Simpan Peminjaman ]         |
+---------------------------------------+
```

### Form Pengembalian

```
Pengembalian Buku

Cari transaksi aktif: [ Nama anggota / judul buku... ]

| Anggota      | Buku            | Tgl Pinjam | Aksi        |
|--------------|-----------------|------------|-------------|
| Siti Aminah  | Bumi Manusia    | 15/05/2024 | Kembalikan  |
| Budi Santoso | Laskar Pelangi  | 18/05/2024 | Kembalikan  |
| Dewi Lestari | Negeri 5 Menara | 19/05/2024 | Kembalikan  |
```

**Alur:** Petugas mencari transaksi aktif dulu → klik tombol "Kembalikan" → stok bertambah 1.

---

### Riwayat Peminjaman Per Anggota

```
Riwayat Peminjaman — Siti Aminah

| Buku            | Pinjam     | Kembali    | Status        |
|-----------------|------------|------------|---------------|
| Laskar Pelangi  | 01/07/2024 | 10/07/2024 | Selesai       |
| Bumi Manusia    | 15/07/2024 | -          | Dipinjam      |
| Negeri 5 Menara | 20/06/2024 | 28/06/2024 | Selesai       |
| Pulang          | 05/06/2024 | 12/06/2024 | Selesai       |
```

### Wireframe Halaman "Registrasi Anggota Baru"

```
+--------------------------------------------------+
|                    SIMPUS-Mini                    |
|--------------------------------------------------|
|                                                  |
|            [ Registrasi Anggota Baru ]           |
|                                                  |
|   Nama Lengkap : [_______________________]       |
|   NIS/NIM      : [_______________________]       |
|   Alamat       : [_______________________]       |
|   No. Telepon  : [_______________________]       |
|   Username     : [_______________________]       |
|   Password     : [_______________________]       |
|   Konfirmasi   : [_______________________]       |
|                                                  |
|              [ Daftar Sekarang ]                 |
|                                                  |
|   Sudah punya akun? Login di sini                |
+--------------------------------------------------+
```

### User Flow Baru "Petugas Mencari Anggota dengan Tunggakan Lewat Jatuh Tempo"

```
[Petugas Login] -> [Dashboard] -> [Menu "Riwayat/Transaksi"] -> [Filter: Status = "Terlambat"] -> [Sistem tampilkan daftar anggota bertunggakan] -> [Pilih anggota] -> [Lihat detail transaksi & hari keterlambatan] -> [Tandai "Tindak Lanjuti"] -> [Kembali ke daftar]
```
