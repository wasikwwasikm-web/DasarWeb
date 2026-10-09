document.addEventListener("DOMContentLoaded", function () {
  muatTabel({
    urlJson: "../../data/buku.json",
    namaKolom: ["judul", "pengarang", "tahun", "stok", "kategori"]
  });
});
