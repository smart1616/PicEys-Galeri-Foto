<?php
include 'config.php';
include 'header.php';
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

if(isset($_POST['upload'])){
    $judul = trim($_POST['judul']);
    if(!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK){
        echo '<div class="alert alert-danger">Silakan pilih file gambar.</div>';
    } else {
        $f = $_FILES['foto'];
        $allowed = ['image/jpeg','image/png','image/webp'];
        if(!in_array($f['type'], $allowed)){
            echo '<div class="alert alert-danger">Format file tidak didukung (jpg/png/webp).</div>';
        } else {
            $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
            $newName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            if(!is_dir('uploads')) mkdir('uploads', 0755, true);
            if(move_uploaded_file($f['tmp_name'], 'uploads/' . $newName)){
                $stmt = $koneksi->prepare("INSERT INTO fotos (user_id, judul, file, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("iss", $_SESSION['user_id'], $judul, $newName);
                $stmt->execute();
                $stmt->close();
                echo '<div class="alert alert-success">Foto berhasil diupload. <a href="view.php">Lihat Galeri</a></div>';
            } else {
                echo '<div class="alert alert-danger">Gagal menyimpan file.</div>';
            }
        }
    }
}
?>

<div class="card p-4">
  <h4 class="mb-3">Upload Foto</h4>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <input class="form-control" name="judul" placeholder="Judul foto" required>
    </div>
    <div class="mb-3">
      <input class="form-control" type="file" name="foto" accept="image/*" required>
    </div>
    <div class="d-grid">
      <button class="btn btn-primary" name="upload">Upload</button>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>
