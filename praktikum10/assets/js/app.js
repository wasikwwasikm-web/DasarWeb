function initNavToggle() {
    const toggleBtn = document.querySelector("#nav-toggle-btn, .nav-toggle-label");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    const syncNavState = () => {
        const isOpen = nav.classList.contains("nav-open");
        toggleBtn.setAttribute("aria-expanded", String(isOpen));
        toggleBtn.setAttribute("aria-label", isOpen ? "Tutup navigasi" : "Buka navigasi");
    };

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
        syncNavState();
    });

    syncNavState();
}

function initPasswordToggle() {
    document.querySelectorAll(".password-toggle").forEach(button => {
        button.addEventListener("click", function () {
            const field = button.closest(".password-field");
            const input = field?.querySelector("input");
            if (!input) return;

            const shouldShow = input.type === "password";
            input.type = shouldShow ? "text" : "password";
            button.setAttribute("aria-pressed", String(shouldShow));
            button.setAttribute(
                "aria-label",
                shouldShow ? "Sembunyikan password" : "Tampilkan password"
            );
        });
    });
}

// ===== Konfirmasi hapus =====
// Tombol Hapus kini berada di dalam <form class="form-hapus" method="post">
// yang benar-benar mengirim request DELETE ke server (buku/hapus.php,
// anggota/hapus.php). Konfirmasi dilakukan pada event "submit" agar bisa
// dibatalkan (preventDefault) sebelum request terkirim.
function initHapusConfirm() {
    const modal = document.getElementById("modal-hapus");
    const modalPesan = document.getElementById("modal-pesan");
    const modalCancel = document.getElementById("modal-cancel");
    const modalConfirm = document.getElementById("modal-confirm");

    if (!modal || !modalPesan || !modalCancel || !modalConfirm) return;

    let pendingForm = null;

    const tutupModal = () => {
        modal.classList.remove("show");
        pendingForm = null;
    };

    modalCancel.addEventListener("click", tutupModal);
    modalConfirm.addEventListener("click", function () {
        if (!pendingForm) return;
        // [New] Simpan form sebelum tutupModal mengosongkan pendingForm.
        const formToSubmit = pendingForm;
        tutupModal();
        HTMLFormElement.prototype.submit.call(formToSubmit);
    });

    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!(form instanceof HTMLFormElement) || !form.classList.contains("form-hapus")) return;

        e.preventDefault();

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        pendingForm = form;
        modalPesan.textContent = 'Yakin ingin menghapus "' + nama + '"?';
        modal.classList.add("show");
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("show")) {
            tutupModal();
        }
    });
}

// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table || input.hasAttribute("data-live-search-url")) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Validasi form (client-side) =====
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

    // [New] Gunakan validasi custom yang berjalan saat mengetik dan submit.
    form.noValidate = true;
    const fields = Array.from(form.querySelectorAll("input, select, textarea"))
        .filter(input => input.type !== "hidden");

    const validateField = input => {
        const value = input.value.trim();
        let message = "";

        if (input.required && value === "") {
            message = "Field ini wajib diisi.";
        } else if (value !== "" && input.name === "tahun") {
            const year = Number(value);
            const currentYear = new Date().getFullYear();
            if (!Number.isInteger(year) || year < 1900 || year > currentYear) {
                message = `Tahun harus di antara 1900-${currentYear}.`;
            }
        } else if (value !== "" && input.name === "stok") {
            const stock = Number(value);
            if (!Number.isInteger(stock) || stock < 0) {
                message = "Stok harus berupa bilangan bulat dan tidak boleh negatif.";
            }
        } else if (value !== "" && input.name === "no_hp") {
            const digits = value.replace(/\D/g, "");
            if (!/^[+\d().\s-]+$/.test(value) || digits.length < 7 || digits.length > 15) {
                message = "Nomor telepon harus berisi 7-15 digit.";
            }
        }

        if (message) {
            tampilkanError(input, message);
            input.classList.add("invalid");
            input.classList.remove("valid");
            return false;
        }

        hapusError(input);
        input.classList.remove("invalid");
        input.classList.toggle("valid", value !== "");
        return true;
    };

    fields.forEach(input => {
        input.addEventListener("input", () => validateField(input));
        input.addEventListener("change", () => validateField(input));
    });

    form.addEventListener("submit", function (e) {
        if (!fields.map(validateField).every(Boolean)) {
            e.preventDefault();
        }
    });
}

// [New] Pesan flash PHP juga ditampilkan sebagai toast custom.
function initFlashToast() {
    const flash = document.querySelector(".flash");
    if (!flash) return;

    const message = flash.textContent.trim();
    const type = flash.classList.contains("flash-error") ? "error" : "success";
    flash.remove();
    showToast(message, type);
}
// ==== Toast notification =====
function showToast(msg, type) {
    const toast = document.getElementById('toast');
    if (!toast) return;

    toast.textContent = msg;
    toast.classList.remove('error');
    toast.classList.toggle('error', type === 'error');
    toast.classList.add('show');
    clearTimeout(toast._hideTimer);
    toast._hideTimer = setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// ==== Live search (AJAX) =====
function initLiveSearch() {
    const input = document.querySelector('[data-live-search-url]');
    const tbody = document.querySelector(".table-responsive table tbody");
    if (!input || !tbody) return;

    let timer = null;
    let controller = null;
    let requestId = 0;
    input.addEventListener('input', function () {
        clearTimeout(timer);
        if (controller) {
            controller.abort();
            controller = null;
        }
        const currentRequestId = ++requestId;
        timer = setTimeout(async () => {
            const q = input.value.trim();
            const requestController = new AbortController();
            controller = requestController;
            try {
                const url = input.dataset.liveSearchUrl;
                const res = await fetch(url + '?q=' + encodeURIComponent(q), {
                    signal: requestController.signal
                });
                if (!res.ok) {
                    throw new Error('Permintaan pencarian gagal: HTTP ' + res.status);
                }
                const data = await res.json();
                if (!Array.isArray(data)) {
                    throw new Error('Respons pencarian bukan berupa daftar buku.');
                }
                if (currentRequestId === requestId) {
                    updateTabelBuku(tbody, data);
                }
            } catch (err) {
                if (err.name !== 'AbortError') {
                    console.error('Fetch error:', err);
                    // [New] Tampilkan kegagalan pencarian melalui notifikasi custom.
                    showToast('Pencarian gagal. Silakan coba lagi.', 'error');
                }
            } finally {
                if (controller === requestController) {
                    controller = null;
                }
            }
        }, 300);
    });
}
function updateTabelBuku(tbody, data) {
    // [New] Pengunjung tanpa sesi login hanya mendapat hasil baca, bukan aksi CRUD.
    const canManage = document.getElementById("search-input")?.dataset.canManage === "true";
    if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9">Tidak ada hasil.</td></tr>';
        return;
    }
    tbody.innerHTML = data.map(b => `
        <tr>
            <td>${escapeHtml(b.judul)}</td>
            <td>${escapeHtml(b.pengarang)}</td>
            <td>${b.tahun}</td>
            <td>${escapeHtml(b.penerbit)}</td>
            <td>${escapeHtml(b.bahasa)}</td>
            <td>${escapeHtml(b.isbn)}</td>
            <td>${escapeHtml(b.kategori)}</td>
            <td>${b.stok}</td>
            <td>
                <a href="detail.php?id=${encodeURIComponent(b.id)}">Detail</a>
                ${canManage ? `
                <a href="edit.php?id=${encodeURIComponent(b.id)}" class="btn-edit">Edit</a>
                <form class="form-hapus" method="post" action="hapus.php">
                    <input type="hidden" name="id" value="${escapeHtml(b.id)}">
                    <button type="submit" class="btn-hapus">Hapus</button>
                </form>
            ` : '<a href="../auth/login.php">Login untuk mengelola</a>'}
            </td>
        </tr>
    `).join('');
}

function escapeHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}


document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initPasswordToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    initFlashToast();
    initLiveSearch();
});
