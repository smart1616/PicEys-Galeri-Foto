<?php
include 'config.php';
include 'header.php';
?>
<div class="text-center">
  <h1 class="display-6 gallery-title">Selamat Datang di PicEys</h1>
  <p class="text-muted">Unggah, lihat, dan beri like pada foto.<br>Login agar bisa upload & like.</p>

  <div class="mt-3">
    <a href="view.php" class="btn btn-outline-dark me-2">Lihat Galeri</a>
    <?php if(isset($_SESSION['user_id'])): ?>
      <a href="upload.php" class="btn btn-primary">Upload Foto</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-primary">Login / Register</a>
    <?php endif; ?>
  </div>
</div>

<?php include 'footer.php'; ?>
