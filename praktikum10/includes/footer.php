</main>

<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 10</p>
</footer>
<div class="modal-overlay" id="modal-hapus">
    <div class="modal-box">
        <h3>Konfirmasi Hapus</h3>
        <p id="modal-pesan">Yakin ingin menghapus data ini?</p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" id="modal-cancel">Batal</button>
            <button type="button" class="btn-confirm" id="modal-confirm">Hapus</button>
        </div>
    </div>
</div>
<!-- [New] Live region agar notifikasi custom diumumkan oleh pembaca layar. -->
<div id="toast" role="status" aria-live="polite"></div>

<script src="<?php echo $base; ?>assets/js/app.js?v=<?php echo filemtime(__DIR__ . '/../assets/js/app.js'); ?>"></script>
<?php if (!empty($extra_scripts)):
    foreach ($extra_scripts as $src): ?>
        <script src="<?php echo $src; ?>"></script>
    <?php endforeach;
endif; ?>
</body>

</html>
