function initNavTonggle() {
    const toggleButton = document.getElementById("nav-toggle-btn");
    const navMenu = document.querySelector("header nav");

    if (!toggleButton || !navMenu) return;

    toggleButton.addEventListener('click', function () {
        navMenu.classList.toggle("nav-open");
    });
}
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
    document.querySelectorAll('.btn-hapus').forEach(function (button) {
        button.addEventListener('click', function () {
            const row = button.closest("tr");
            const table = button.closest("table");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");

            if (yakin && row) {
                row.remove();
                updateTableCounter(table);
            }
        });
    });
}
function initTableFilter() {
    const input = document.getElementById("search-Input");
    const table = document.querySelector(".table-responsive table");

    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.trim().toLowerCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            const judulCell = row.querySelector("td");
            const text = judulCell ? judulCell.textContent.toLowerCase() : "";
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

    const requiredFields = [
        { name: "judul", label: "Judul", message: "Field Judul wajib diisi." },
        { name: "pengarang", label: "Pengarang", message: "Field Pengarang wajib diisi." },
        { name: "tahun", label: "Tahun", message: "Field Tahun wajib diisi." },
        { name: "isbn", label: "ISBN", message: "Field ISBN wajib diisi." },
        { name: "stok", label: "Stok", message: "Field Stok wajib diisi." },
        { name: "kategori", label: "Kategori", message: "Field Kategori wajib diisi." },
        { name: "nama_lengkap", label: "Nama", message: "Field Nama wajib diisi." },
        { name: "email", label: "Email", message: "Field Email wajib diisi." },
        { name: "no_anggota", label: "Nomor Anggota", message: "Field Nomor Anggota wajib diisi." },
        { name: "tanggal_lahir", label: "Tanggal Lahir", message: "Field Tanggal Lahir wajib diisi." },
        { name: "alamat", label: "Alamat", message: "Field Alamat wajib diisi." }
    ];

    form.addEventListener("submit", function (e) {
        let valid = true;

        requiredFields.forEach(function (field) {
            const input = form.querySelector("[name='" + field.name + "']");
            if (!input) return;

            const value = input.value.trim();

            if (value === "") {
                tampilkanError(input, field.message);
                valid = false;
                return;
            }

            if (field.name === "isbn" && !/^[0-9-]+$/.test(value)) {
                tampilkanError(input, "ISBN hanya boleh berisi angka dan tanda hubung.");
                valid = false;
                return;
            }

            if (field.name === "email" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                tampilkanError(input, "Format email tidak valid.");
                valid = false;
                return;
            }

            if (field.name === "tahun" && (Number(value) < 1900 || Number(value) > 2100)) {
                tampilkanError(input, "Tahun harus berada di rentang 1900 sampai 2100.");
                valid = false;
                return;
            }

            if (field.name === "stok" && Number(value) < 0) {
                tampilkanError(input, "Stok tidak boleh kurang dari 0.");
                valid = false;
                return;
            }

            hapusError(input);
        });

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initNavTonggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
