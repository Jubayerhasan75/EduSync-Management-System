<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: ../" . $_SESSION['role'] . "/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduSync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f4f7fe; font-family: 'Inter', sans-serif; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: white; padding: 40px; border-radius: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .password-toggle-group { position: relative; display: flex; align-items: center; }
        .password-toggle-group input { width: 100%; padding-right: 40px; }
        .toggle-password { position: absolute; right: 15px; cursor: pointer; color: #6c757d; z-index: 10; }
        .back-link { display: inline-block; text-decoration: none; color: #6c757d; font-weight: 600; transition: 0.3s; }
        .back-link:hover { color: #4e73df; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="text-center mb-4">
            <a href="../index.php" class="text-decoration-none"><h2 class="fw-bold text-primary">EduSync.</h2></a>
            <p class="text-muted small">Sign in to your account</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger border-0 small">Invalid credentials!</div>
        <?php endif; ?>

        <form action="login_process.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-bold small">Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold small">Password</label>
                <div class="password-toggle-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword"></i>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold small">Login Role</label>
                <select name="role" class="form-select" required>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="principal">Principal</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">LOGIN</button>
        </form>

        <div class="text-center mt-4 border-top pt-4">
            <a href="../index.php" class="back-link"><i class="fa-solid fa-arrow-left me-2"></i>Back to Homepage</a>
        </div>
    </div>
    
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>