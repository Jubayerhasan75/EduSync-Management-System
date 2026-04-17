<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: " . $_SESSION['role'] . "/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSync | Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            padding: 3.5rem 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 90%;
            text-align: center;
        }
        .logo-text {
            font-size: 4rem;
            font-weight: 800;
            color: #4e73df;
            letter-spacing: -2px;
            margin-bottom: 0.5rem;
        }
        .sub-text {
            font-weight: 600;
            color: #5a5c69;
            letter-spacing: 2px;
            margin-bottom: 2.5rem;
            font-size: 0.9rem;
        }
        .btn-custom {
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        .btn-login {
            background-color: #4e73df;
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.4);
        }
        .btn-login:hover {
            background-color: #224abe;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.6);
        }
        .btn-reg {
            background-color: transparent;
            color: #4e73df;
            border: 2px solid #4e73df;
        }
        .btn-reg:hover {
            background-color: #4e73df;
            color: white;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="glass-card">
        <h1 class="logo-text">EduSync<span style="color:#f6c23e;">.</span></h1>
        <p class="sub-text text-uppercase">Next-Gen Class Management</p>
        
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
            <a href="auth/login.php" class="btn btn-custom btn-login">Sign In to Account</a>
            <a href="auth/register.php" class="btn btn-custom btn-reg">Register Now</a>
        </div>
        
        <div class="mt-5 pt-3">
            <p class="text-muted small mb-0">&copy; 2026 EduSync Systems. All rights reserved.</p>
        </div>
    </div>
</body>
</html>