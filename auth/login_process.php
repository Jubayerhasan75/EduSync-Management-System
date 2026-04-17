<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = md5($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND role = '$role'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['class_name'] = $user['class_name'];
        $_SESSION['section'] = $user['section'];

        header("Location: ../" . $role . "/dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=1");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>