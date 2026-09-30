function initNavTonggle() {
    const toggleButton = document.getElementById("nav-toggle-btn");
    const navMenu = document.querySelector("header nav");

    if (!toggleButton || !navMenu) return;

    toggleButton.addEventListener('click', function () {
        navMenu.classList.toggle("nav-open");
    });
}

function initHapusConfirm() {
    document.querySelectorAll('.btn-hapus').forEach(function (button) {
        button.addEventListener('click', function () {
            const row = button.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            if (yakin && row) {
                row.remove();
            }
        });
    });
}

function initTableFilter() {
    const Input = document.getElementById("search-Input");
    const table = document.querySelector(".table-responsive table");

    if (!Input || !table) return;

    Input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr")
        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? "" : "none";
        });
    });
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

    form.addEventListener("submit", function (e) {
        let valid = true;

        const judul = form.querySelector("[name= 'judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

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
