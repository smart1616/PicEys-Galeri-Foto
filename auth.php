<?php
function isLogin(){
    return isset($_SESSION['user_id']);
}

function isAdmin(){
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function requireLogin(){
    if(!isLogin()){
        header("Location: login.php");
        exit;
    }
}
