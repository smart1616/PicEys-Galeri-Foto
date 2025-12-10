<?php
include 'config.php';
include 'header.php';

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT id,password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows === 0){
        echo '<div class="alert alert-danger">Username tidak ditemukan.</div>';
    } else {
        $row = $res->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Password salah.</div>';
        }
    }
    $stmt->close();
}
?>

<div class="card p-4 form-card">
  <h4 class="text-center mb-3">Masuk</h4>
  <form method="post" autocomplete="off">
    <div class="mb-3">
      <input class="form-control" name="username" placeholder="Username" required>
    </div>
    <div class="mb-3">
      <input class="form-control" name="password" type="password" placeholder="Password" required>
    </div>
    <div class="d-grid">
      <button class="btn btn-primary" name="login">Login</button>
    </div>
  </form>
  <p class="mt-3 text-center"><small>Belum punya akun? <a href="register.php">Register</a></small></p>
</div>

<?php include 'footer.php'; ?>
