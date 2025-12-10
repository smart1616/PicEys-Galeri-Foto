<?php
include 'config.php';
include 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $koneksi->prepare("SELECT f.*, u.username FROM fotos f LEFT JOIN users u ON f.user_id=u.id WHERE f.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows === 0){
    echo '<div class="alert alert-warning">Foto tidak ditemukan.</div>';
    include 'footer.php';
    exit;
}
$foto = $res->fetch_assoc();
$stmt->close();

// hitung like
$likes = $koneksi->query("SELECT COUNT(*) AS jml FROM likes WHERE foto_id = $id")->fetch_assoc()['jml'];
$hasLiked = false;
if(isset($_SESSION['user_id'])){
    $uid = (int)$_SESSION['user_id'];
    $chk = $koneksi->query("SELECT id FROM likes WHERE foto_id = $id AND user_id = $uid")->num_rows;
    $hasLiked = $chk > 0;
}
?>

<div class="row">
  <div class="col-md-8 mb-3">
    <div class="card">
      <img src="uploads/<?= htmlspecialchars($foto['file']) ?>" class="card-img-top" alt="<?= htmlspecialchars($foto['judul']) ?>">
      <div class="card-body">
        <h4><?= htmlspecialchars($foto['judul']) ?></h4>
        <p class="text-muted">Diunggah oleh <?= htmlspecialchars($foto['username'] ?: 'Anon') ?> • <?= $foto['created_at'] ?></p>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card p-3">
      <p><strong>Like:</strong> <span id="like-count"><?= (int)$likes ?></span></p>
      <?php if(isset($_SESSION['user_id'])): ?>
        <?php if(!$hasLiked): ?>
          <a href="like.php?act=like&id=<?= $id ?>" class="btn btn-outline-danger w-100"><i class="bi bi-heart"></i> Like</a>
        <?php else: ?>
          <a href="like.php?act=unlike&id=<?= $id ?>" class="btn btn-danger w-100"><i class="bi bi-heart-fill"></i> Unlike</a>
        <?php endif; ?>
        <a href="delete.php?id=<?= $id ?>" class="btn btn-danger w-100 mt-3" onclick="return confirm('Yakin ingin menghapus foto ini?')"> Hapus Foto </a>
      <?php else: ?>
        <a href="login.php" class="btn btn-primary w-100">Login untuk like</a>
      <?php endif; ?>
      <a href="view.php" class="btn btn-secondary mt-3 w-100">Kembali</a>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
