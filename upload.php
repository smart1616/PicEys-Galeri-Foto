<?php
include 'config.php';
include 'auth.php';
requireLogin();
include 'header.php';

if(isset($_POST['upload'])){
    $judul=$_POST['judul'];
    $f=$_FILES['foto'];

    $name=time()."_".$f['name'];
    move_uploaded_file($f['tmp_name'],"uploads/".$name);

    $stmt=$koneksi->prepare("INSERT INTO fotos(user_id,judul,file,created_at) VALUES(?,?,?,NOW())");
    $stmt->bind_param("iss",$_SESSION['user_id'],$judul,$name);
    $stmt->execute();

    echo "<div class='alert alert-success'>Upload berhasil</div>";
}
?>

<form method="post" enctype="multipart/form-data" class="card p-4">
  <input name="judul" class="form-control mb-3" placeholder="Judul">
  <input type="file" name="foto" class="form-control mb-3">
  <button name="upload" class="btn btn-primary">Upload</button>
</form>

<?php include 'footer.php'; ?>
