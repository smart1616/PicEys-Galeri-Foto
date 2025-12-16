<?php
include 'config.php';
include 'header.php';

if(isset($_POST['login'])){
    $u = $_POST['username'];
    $p = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT id,password,role FROM users WHERE username=?");
    $stmt->bind_param("s",$u);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows){
        $row = $res->fetch_assoc();
        if(password_verify($p,$row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header("Location: index.php");
            exit;
        }
    }
    echo "<div class='alert alert-danger'>Login gagal</div>";
}
?>

<form method="post" class="form-card card p-4">
  <input name="username" class="form-control mb-3" placeholder="Username">
  <input name="password" type="password" class="form-control mb-3" placeholder="Password">
  <button name="login" class="btn btn-primary w-100">Login</button>
</form>

<?php include 'footer.php'; ?>
