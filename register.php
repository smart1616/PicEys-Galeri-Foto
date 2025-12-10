<?php
include 'config.php';
include 'header.php';

if(isset($_POST['register'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if($username === "" || $password === ""){
        echo '<div class="alert alert-danger">Isi semua field.</div>';
    } else {
        // Cek user sudah ada
        $stmt = $koneksi->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0){
            echo '<div class="alert alert-warning">Username sudah dipakai.</div>';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $koneksi->prepare("INSERT INTO users (username,password) VALUES (?,?)");
            $ins->bind_param("ss", $username, $hash);
            $ins->execute();
            echo '<div class="alert alert-success">Registrasi berhasil. <a href="login.php">Login</a></div>';
        }
        $stmt->close();
    }
}
?>

<div class="card p-4 form-card">
  <h4 class="text-center mb-3">Daftar Akun</h4>
  <form method="post" autocomplete="off">
    <div class="mb-3">
      <input class="form-control" name="username" placeholder="Username" required>
    </div>
    <div class="mb-3">
      <input class="form-control" name="password" type="password" placeholder="Password" required>
    </div>
    <div class="d-grid">
      <button class="btn btn-primary" name="register">Register</button>
    </div>
  </form>
  <p class="mt-3 text-center"><small>Sudah punya akun? <a href="login.php">Login</a></small></p>
</div>

<?php include 'footer.php'; ?>
