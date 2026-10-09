async function muatTabel(config) {
  const { urlJson, namaKolom, tbodySelector = ".table-responsive table tbody", loadingId = "loading-indicator" } = config;

  const tbody = document.querySelector(tbodySelector);
  const loading = document.getElementById(loadingId);
  if (!tbody) return;

  loading.style.display = "block";
  tbody.innerHTML = "";

  try {
    // Simulasi delay jaringan
    await new Promise((resolve) => setTimeout(resolve, 3000));

    const res = await fetch(urlJson);
    if (!res.ok) {
      throw new Error("Gagal mengambil data (status " + res.status + ")");
    }
    const data = await res.json();

    data.forEach(function (item) {
      const tr = document.createElement("tr");

      // Buat <td> untuk setiap kolom yang diminta
      const selData = namaKolom.map(function (kunci) {
        return "<td>" + item[kunci] + "</td>";
      }).join("");

      // Kolom Aksi (Edit + Hapus)
      const selAksi =
        "<td>" +
          "<button type=\"button\">Edit</button> " +
          "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
        "</td>";

      tr.innerHTML = selData + selAksi;
      tbody.appendChild(tr);
    });
  } catch (err) {
    const jumlahKolom = namaKolom.length + 1;   // +1 untuk kolom Aksi
    tbody.innerHTML =
      "<tr><td colspan=\"" + jumlahKolom + "\">Gagal memuat data: " + err.message + "</td></tr>";
  } finally {
    loading.style.display = "none";
  }
}
