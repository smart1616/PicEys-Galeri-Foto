<?php
include 'config.php';
include 'auth.php';
requireLogin();

$id=(int)$_GET['id'];
$f=$koneksi->query("SELECT * FROM fotos WHERE id=$id")->fetch_assoc();

if(!isAdmin() && $f['user_id']!=$_SESSION['user_id']){
    die("Akses ditolak");
}

unlink("uploads/".$f['file']);
$koneksi->query("DELETE FROM likes WHERE foto_id=$id");
$koneksi->query("DELETE FROM fotos WHERE id=$id");

header("Location: view.php");
exit;
