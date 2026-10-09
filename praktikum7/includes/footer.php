</main>
<footer class="text-center py-4 text-secondary">
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 7</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base; ?>assets/js/app.js"></script>
<?php if (!empty($extra_scripts)):
    foreach ($extra_scripts as $src): ?>
        <script src="<?php echo $src; ?>"></script>
    <?php endforeach; endif; ?>
</body>

</html>
