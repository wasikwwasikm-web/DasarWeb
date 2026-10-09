document.addEventListener("DOMContentLoaded", function () {
  muatTabel({
    urlJson: "../../data/anggota.json",
    namaKolom: ["no_anggota", "nama", "alamat", "no_hp"]
  });
});
