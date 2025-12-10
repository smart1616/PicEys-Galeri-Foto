<?php
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Ambil nama file foto
$q = $koneksi->query("SELECT file FROM fotos WHERE id='$id'");
$data = $q->fetch_assoc();
$file = $data['file'];

// Hapus file fisik dari folder uploads/
$path = "uploads/" . $file;
if (file_exists($path)) {
    unlink($path);
}

// Hapus likes yang terkait dengan foto
$koneksi->query("DELETE FROM likes WHERE foto_id='$id'");

// Hapus foto dari database
$koneksi->query("DELETE FROM fotos WHERE id='$id'");

header("Location: view.php");
exit;
?>
