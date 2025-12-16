<?php
include 'config.php';
include 'header.php';

$search = $_GET['q'] ?? '';

if ($search !== '') {

    // MODE SEARCH
    $stmt = $koneksi->prepare("
        SELECT f.*, 
               u.username,
               (SELECT COUNT(*) FROM likes l WHERE l.foto_id = f.id) AS like_count
        FROM fotos f
        LEFT JOIN users u ON f.user_id = u.id
        WHERE f.judul LIKE ?
        ORDER BY f.id DESC
    ");

    $like = "%$search%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $res = $stmt->get_result();

} else {

    // MODE NORMAL
    $res = $koneksi->query("
        SELECT f.*, 
               u.username,
               (SELECT COUNT(*) FROM likes l WHERE l.foto_id = f.id) AS like_count
        FROM fotos f
        LEFT JOIN users u ON f.user_id = u.id
        ORDER BY f.id DESC
    ");
}
?>

<!-- HEADER + SEARCH -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="gallery-title">Galeri Foto</h4>
  <form class="d-flex" method="get">
    <input 
      class="form-control me-2"
      name="q"
      placeholder="Cari judul..."
      value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-outline-dark">Cari</button>
  </form>
</div>

<!-- LIST FOTO -->
<div class="row">
<?php while($r = $res->fetch_assoc()): ?>
  <div class="col-6 col-md-4 col-lg-3 mb-4">
    <div class="card h-100">
      <a href="detail.php?id=<?= (int)$r['id'] ?>">
        <img src="uploads/<?= htmlspecialchars($r['file']) ?>" 
             class="card-img-top" 
             alt="<?= htmlspecialchars($r['judul']) ?>">
      </a>
      <div class="card-body">
        <h6 class="card-title mb-1">
          <?= htmlspecialchars($r['judul']) ?>
        </h6>
        <small class="text-muted">
          oleh <?= htmlspecialchars($r['username'] ?: 'Anon') ?>
        </small>
        <div class="mt-2">
          <i class="bi bi-heart-fill text-danger"></i>
          <?= (int)$r['like_count'] ?>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>

<?php include 'footer.php'; ?>
