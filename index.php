<?php
include 'config.php';
include 'header.php';
?>

<div class="text-center">
  <h1 class="gallery-title">Selamat Datang di PicEys</h1>
  <p class="text-muted">Unggah, lihat, dan beri like foto.</p>

  <a href="view.php" class="btn btn-outline-dark">Lihat Galeri</a>
  <?php if(isset($_SESSION['user_id'])): ?>
    <a href="upload.php" class="btn btn-primary">Upload</a>
  <?php else: ?>
    <a href="login.php" class="btn btn-primary">Login</a>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
