<?php
include 'config.php';
include 'auth.php';
requireLogin();

$id=(int)$_GET['id'];
$uid=$_SESSION['user_id'];

$cek=$koneksi->query("SELECT id FROM likes WHERE foto_id=$id AND user_id=$uid");
if($cek->num_rows){
    $koneksi->query("DELETE FROM likes WHERE foto_id=$id AND user_id=$uid");
}else{
    $koneksi->query("INSERT INTO likes(foto_id,user_id) VALUES($id,$uid)");
}

header("Location: detail.php?id=$id");
exit;
