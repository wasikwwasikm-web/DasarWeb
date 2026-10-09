function updateTableCounter(table) {
    const counter = document.getElementById("table-counter");
    if (!table || !counter) return;

    const rows = table.querySelectorAll("tbody tr");
    const visibleRows = Array.from(rows).filter(function (row) {
        return row.style.display !== "none";
    });

    const total = rows.length;
    const shown = visibleRows.length;
    const label = table.dataset.label || "data";
    counter.textContent = "Menampilkan " + shown + " dari " + total + " " + label;
}
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target.closest(".form-hapus");
        if (!form) return;

        const nama = form.dataset.nama || "data ini";
        if (!confirm("Yakin ingin menghapus \"" + nama + "\"?")) {
            e.preventDefault();
        }
    });
}
function initTableFilter() {
    // DIPERBAIKI: ID pencarian konsisten dengan kedua halaman daftar.
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");

    if (!input || !table) return;

    input.addEventListener("input", function () {
        const keyword = input.value.trim().toLowerCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const text = Array.from(row.querySelectorAll("td"))
                .map(function (cell) {
                    return cell.textContent.toLowerCase();
                })
                .join(" ");

            row.style.display = text.includes(keyword) ? "" : "none";
        });

        updateTableCounter(table);
    });

    updateTableCounter(table);
}
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    // DIPERBAIKI: aturan wajib mengikuti atribut form; field opsional tidak dipaksa diisi.
    const requiredFields = Array.from(form.querySelectorAll("[required]"));

    form.addEventListener("submit", function (e) {
        let valid = true;

        requiredFields.forEach(function (input) {
            const value = input.value.trim();

            if (value === "") {
                tampilkanError(input, "Field " + input.labels[0].textContent + " wajib diisi.");
                valid = false;
                return;
            }

            hapusError(input);
        });

        // DIPERBAIKI: ISBN hanya divalidasi formatnya jika pengguna mengisinya.
        const isbn = form.querySelector("[name='isbn']");
        if (isbn && isbn.value.trim() !== "" && !/^[0-9-]+$/.test(isbn.value.trim())) {
                tampilkanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung.");
                valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
