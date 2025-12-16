<?php
include 'config.php';
include 'header.php';

/*
  Demi keamanan:
  TOKEN ini kata rahasia
*/
$ADMIN_TOKEN = "tias123";

if(isset($_POST['register_admin'])){
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $token    = $_POST['token'];

    if($token !== $ADMIN_TOKEN){
        echo "<div class='alert alert-danger'>Token admin salah!</div>";
    } else {
        // cek username
        $cek = $koneksi->prepare("SELECT id FROM users WHERE username=?");
        $cek->bind_param("s",$username);
        $cek->execute();
        $cek->store_result();

        if($cek->num_rows > 0){
            echo "<div class='alert alert-warning'>Username sudah dipakai</div>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $koneksi->prepare(
                "INSERT INTO users (username,password,role)
                 VALUES (?,?,'admin')"
            );
            $ins->bind_param("ss",$username,$hash);
            $ins->execute();

            echo "<div class='alert alert-success'>
                    Admin berhasil dibuat.
                    <a href='login.php'>Login</a>
                  </div>";
        }
        $cek->close();
    }
}
?>

<div class="card p-4 form-card">
  <h4 class="text-center mb-3">Register Admin</h4>
  <form method="post">
    <input class="form-control mb-3" name="username" placeholder="Username" required>
    <input class="form-control mb-3" name="password" type="password" placeholder="Password" required>
    <input class="form-control mb-3" name="token" placeholder="Token Admin" required>
    <button name="register_admin" class="btn btn-danger w-100">
      Daftar Admin
    </button>
  </form>
</div>

<?php include 'footer.php'; ?>
