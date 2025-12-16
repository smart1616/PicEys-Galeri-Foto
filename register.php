<?php
include 'config.php';
include 'header.php';

if(isset($_POST['register'])){
    $u=$_POST['username'];
    $p=password_hash($_POST['password'],PASSWORD_DEFAULT);

    $stmt=$koneksi->prepare("INSERT INTO users(username,password,role) VALUES(?,?, 'user')");
    $stmt->bind_param("ss",$u,$p);
    $stmt->execute();

    echo "<div class='alert alert-success'>Register berhasil</div>";
}
?>

<form method="post" class="form-card card p-4">
  <input name="username" class="form-control mb-3" placeholder="Username">
  <input name="password" type="password" class="form-control mb-3" placeholder="Password">
  <button name="register" class="btn btn-primary w-100">Register</button>
</form>

<?php include 'footer.php'; ?>
