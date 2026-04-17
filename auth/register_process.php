<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = md5($_POST['password']);
    $role = $conn->real_escape_string($_POST['role']);
    
    if($role === 'teacher') {
        $secret = $_POST['secret_code'];
        if($secret !== '1010') {
            header("Location: register.php?error=code");
            exit();
        }
    }

    $student_id = NULL;
    if($role === 'student') {
        $student_id = $conn->real_escape_string($_POST['student_id']);
        $checkId = $conn->query("SELECT student_id FROM users WHERE student_id = '$student_id'");
        if($checkId->num_rows > 0) {
            header("Location: register.php?error=id_exists");
            exit();
        }
    }
    
    $class_name = isset($_POST['class_name']) ? $conn->real_escape_string($_POST['class_name']) : NULL;
    $section = isset($_POST['section']) ? $conn->real_escape_string($_POST['section']) : NULL;
    $designation = isset($_POST['designation']) ? $conn->real_escape_string($_POST['designation']) : NULL;

    $pic_name = 'default.png';
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "../uploads/profiles/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $pic_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_dir . $pic_name);
    }

    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");

    if ($checkEmail->num_rows > 0) {
        header("Location: register.php?error=exists");
        exit();
    } else {
        $sql = "INSERT INTO users (student_id, name, email, phone, password, role, class_name, section, designation, profile_pic) VALUES ('$student_id', '$name', '$email', '$phone', '$password', '$role', '$class_name', '$section', '$designation', '$pic_name')";
        if ($conn->query($sql)) {
            $conn->query("INSERT INTO logs (user_id, action) VALUES (0, 'New user registered: $email')");
            header("Location: login.php?success=registered");
            exit();
        }
    }
}
?>