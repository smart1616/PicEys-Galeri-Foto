<?php
include 'config.php';
if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$act = $_GET['act'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$uid = (int)$_SESSION['user_id'];

if($act === 'like'){
    // cek dulu
    $chk = $koneksi->prepare("SELECT id FROM likes WHERE foto_id = ? AND user_id = ?");
    $chk->bind_param("ii", $id, $uid);
    $chk->execute();
    $chk->store_result();
    if($chk->num_rows === 0){
        $ins = $koneksi->prepare("INSERT INTO likes (foto_id, user_id) VALUES (?, ?)");
        $ins->bind_param("ii", $id, $uid);
        $ins->execute();
        $ins->close();
    }
    $chk->close();
} elseif($act === 'unlike'){
    $del = $koneksi->prepare("DELETE FROM likes WHERE foto_id = ? AND user_id = ?");
    $del->bind_param("ii", $id, $uid);
    $del->execute();
    $del->close();
}

header("Location: detail.php?id=$id");
exit;
